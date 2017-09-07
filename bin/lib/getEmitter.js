const Emitter = require('events').EventEmitter;

module.exports = function () {
    var emitter = new Emitter();
    emitter.on('error', function (err) {
        console.log(err);
        process.exit(1);
    });

    emitter.on('warn', function (data) {
        console.warn(data);
    });

    //emitter.on('log', stdout.write.bind(stdout));

    return emitter;
};
