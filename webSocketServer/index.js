/**
 * Created by lenovo on 5/10/2017.
 */
const http = require('http');
const app = http.createServer(handler);
const fs = require('fs');
const config = setConfig();
const io = require('socket.io')(app);
const Redis = require('ioredis');
const redis = new Redis(config.redis);
let interviewers = [];

let countClient = 0;

app.listen(config.httpServer.port, () => {
    console.log(`Server is running at ${config.httpServer.host}:${config.httpServer.port}`);
});

io.on('connection', socket => {

    countClient ++;
    console.log(`现在共有连接的客户端：${countClient}`);
    console.log(`现在共有多少登录用户：${calcInterviewer()}`);

    redis.on('pmessage', (subscribed, channel, message) => {
        // console.log(channel + ':' + message);
        message = JSON.parse(message);
        // console.log(channel + ':' + message.event);
        switchEventHandler(message, channel);
    });

    function isLogin(obj) {
        return new Boolean(obj.is_login).valueOf()
    }

    function calcInterviewer() {
        let count = 0;
        for (let key in interviewers) {
            count ++;
        }
        return count;
    }

    function switchEventHandler(message, channel) {
        switch (channel) {
            case 'receptionLogin':
            case "interviewerPostLoginChannel":
                interviewerLoginEvent(message.data, channel);
                break;
            case "interviewerGetLogoutChannel":
                interviewerLogoutEvent(message.data, channel);
                break;
            case "updateSignerListChannel":
                updateSignerListEvent(message.data, channel);
                break;
            case 'messageToReceptionChannel':
                messageToReceptionEvent(message.data, channel);
                break;
        }
    }

    /**
     * 退出
     * @param interviewer
     * @param channel
     */
    function interviewerLogoutEvent(interviewer, channel) {

        console.log(interviewer.unique_id);

        if (Object.prototype.hasOwnProperty.call(interviewers, interviewer.unique_id)) {
            io.emit('logout', interviewers[interviewer.unique_id]);

            delete interviewers[interviewer.unique_id];
            console.log(`${interviewer.unique_id} 退出  现在共有：${calcInterviewer()} 人`);
        }
    }

    /**
     * 登录
     * @param interviewer
     * @param channel
     */
    function interviewerLoginEvent(interviewer, channel) {

        if (isLogin(interviewer)) {
            io.emit(channel, {code: 400, unique_id: interviewer.unique_id, message: "已登录"});
            return;
        }else {
            io.emit(channel, {code: 200, unique_id: interviewer.unique_id, message: "success"});
        }

        interviewers[interviewer.unique_id] = interviewer;
        console.info(`${interviewer.unique_id} 加入  现在共有：${calcInterviewer()} 人`);
    }

    /**
     *  更新列表
     * @param dataList
     * @param channel
     */
    function updateSignerListEvent(dataList, channel) {
        io.emit(channel, dataList);
    }

    function messageToReceptionEvent(sender, channel) {
        let broadcast = {
            unique_id: sender.unique_id,
            user: `${sender.department} ${sender.number}`,
            msg: sender.msg,
            time: new Date().format('yyyy-MM-dd hh:mm:ss')
        };

        console.log(`${broadcast.user} 说：${broadcast.msg}`);

        io.emit('message', broadcast);
    }

    socket.on('message', (obj) => {

        obj = JSON.parse(JSON.stringify(obj));

        let broadcast = {
            unique_id: obj.unique_id,
            user: `${interviewers[obj.unique_id].department} ${interviewers[obj.unique_id].number}`,
            msg: obj.msg,
            time: new Date().format('yyyy-MM-dd hh:mm:ss')
        };

        console.log(`${broadcast.user} 说：${broadcast.msg}`);

        io.emit('message', broadcast);
    })

    socket.on('receptionLogin', (obj) => {
        obj = JSON.parse(JSON.stringify(obj));
        switchEventHandler({ data: obj }, 'receptionLogin')
    });

    socket.on('disconnect', (obj, fn) => {

        countClient --;
        // if (interviewers.hasOwnProperty(socket.name)) {
        //     io.emit('logout', interviewers[socket.name]);
        //
        //     delete interviewers[socket.name];
        //     console.log(`${socket.name} 退出   现在共有：${calcInterviewer()}`);
        // }
    });
});

// 必须要
redis.psubscribe('*', function(err, count) {
    // console.log(count);
});

function handler(req, res) {
    fs.readFile(`${__dirname}/index.html`, function (err, data) {
        if (err) {
            res.statusCode = 200;
            res.setHeader('Content-Type', 'text/plain');
            res.end('');
        }
        res.statusCode = 200;
        res.setHeader('Content-Type', 'text/html');
        res.end(data.toString());
    });
}

function setConfig() {
    let flag = fs.existsSync(`${__dirname}/env.json`);
    if (flag) {
        return JSON.parse(fs.readFileSync(`${__dirname}/env.json`).toString());
    }
    return {};
}

Date.prototype.format = function (fmt) {
    let o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (let k in o) {
        if (new RegExp("(" + k + ")").test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ?
                (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        }
    }

    return fmt;
}