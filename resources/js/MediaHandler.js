const { resolve } = require("path")

class MediaHandler {
    getPermissions() {
        return new Promise((res, rej) => {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then((stream) => {
                    resolve(stream);
                })
                .catch((err) => {
                    throw new Error(`Permission denied ${err}`);
                })
        });
    }
}