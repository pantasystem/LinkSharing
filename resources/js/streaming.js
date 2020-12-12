import Echo from 'laravel-echo';


export class Streaming{

    constructor(){
        this.echo = null;
        
    }

    connect(token){
        if(this.echo != null){
            this.echo.disconnect();
        }
        this.echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001',
            auth: {
                headers: { Authorization: `Bearer ${token}`}
            }
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
