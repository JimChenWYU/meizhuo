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

app.listen(config.httpServer.port, () => {
    console.log(`Server is running at ${config.httpServer.host}:${config.httpServer.port}`);
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