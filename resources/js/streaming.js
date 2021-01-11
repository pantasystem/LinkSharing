import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.io = require('socket.io-client');



export class Streaming{

    constructor(){
        this.echo = null;
        this.connect();
    }

    connect(){
        if(this.echo != null){
            this.echo.disconnect();
        }
        this.echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.host,
            //key: 'd1f04d6670716a2ab185',
            //cluster: 'ap3',
            auth: {
                headers: {
                    'Referer': window.location.host
                }
            },
            encrypted: true,
            authorizer: (channel, options) => {
                console.log('authorizer');
                return {
                    authorize: (socketId, callback) => {
                        axios.post('/broadcasting/auth', {
                            socket_id: socketId,
                            channel_name: channel.name
                        })
                        .then(response => {
                            callback(false, response.data);
                        })
                        .catch(error => {
                            console.log(error);
                            callback(true, error);
                        });
                    }
                };
            },
        });
        console.log(this.echo);
    }
    disconnect(){
        if(this.echo != null){
            this.echo.disconnect();
        }
    }


    getEcho(){
        return this.echo;
    }
}

export default new Streaming();
