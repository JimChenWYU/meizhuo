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

app.listen(config.httpServer.port, () => {
    console.log(`Server is running at ${config.httpServer.host}:${config.httpServer.port}`);
});

io.on('connection', socket => {
    console.log('A client connected');

    redis.on('pmessage', (subscribed, channel, message) => {
        // console.log(channel + ':' + message);
        message = JSON.parse(message);
        // console.log(channel + ':' + message.event);
        switchEventHandler(message, channel);
    });

    function contains(obj, val) {
        for (let i in obj) {
            if (obj[i] === val) { return true; }
        }
        return false;
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
            case "interviewerPostLoginChannel":
                interviewerLoginEvent(message.data, channel);
                break;
            case "interviewerGetLogoutChannel":
                interviewerLogoutEvent(message.data, channel);
                break;
            case "updateSignerListChannel":
                updateSignerListEvent(message.data, channel);
                break;
        }
    }

    /**
     * 退出
     * @param interviewer
     * @param channel
     */
    function interviewerLogoutEvent(interviewer, channel) {

        // console.log(interviewer);

        if (interviewers.hasOwnProperty(interviewer.unique_id)) {
            io.emit('logout', interviewers[interviewer.unique_id]);

            delete interviewers[interviewer.unique_id];
            console.error(`${interviewer.unique_id} 退出  现在共有：${calcInterviewer()} 人`);
        }
    }

    /**
     * 登录
     * @param interviewer
     * @param channel
     */
    function interviewerLoginEvent(interviewer, channel) {

        socket.name = interviewer.unique_id;

        // console.log(interviewer);

        if (contains(interviewers, interviewer.id)) {
            io.emit(channel, {code: 400, unique_id: interviewer.unique_id, message: "已登录"});
            return ;
        }else {
            io.emit(channel, {code: 200, unique_id: interviewer.unique_id, message: "success"});
        }

        if (! interviewers.hasOwnProperty(interviewer.unique_id)) {
            interviewers[interviewer.unique_id] = interviewer;
            console.info(`${socket.name} 加入  现在共有：${calcInterviewer()} 人`);
        } else {
            console.warn(`${socket.name} 已经加入  现在共有：${calcInterviewer()} 人`);
        }
    }

    
    function updateSignerListEvent(dataList, channel) {
        io.emit(channel, dataList);
    }

    socket.on('disconnect', (obj, fn) => {
        // console.log(obj);
        if (interviewers.hasOwnProperty(socket.name)) {
            io.emit('logout', interviewers[socket.name]);

            delete interviewers[socket.name];
            console.log(socket.name+' 退出');
        }
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