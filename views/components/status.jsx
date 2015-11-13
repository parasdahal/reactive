
var Status= React.createClass({


    timeToRelativeTime:function (datetime) {
        //source: http://stackoverflow.com/questions/3075577/convert-mysql-datetime-stamp-into-javascripts-date-format
        var t = datetime.split(/[- :]/);
        // Apply each element to the Date function
        var timeStamp = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

        var now = new Date(),
          secondsPast = (now.getTime() - timeStamp.getTime()) / 1000;
        if(secondsPast < 60){
          return parseInt(secondsPast) + 's';
        }
        if(secondsPast < 3600){
          return parseInt(secondsPast/60) + 'm';
        }
        if(secondsPast <= 86400){
          return parseInt(secondsPast/3600) + 'h';
        }
        if(secondsPast > 86400){
            day = timeStamp.getDate();
            month = timeStamp.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ","");
            year = timeStamp.getFullYear() == now.getFullYear() ? "" :  " "+timeStamp.getFullYear();
            return day + " " + month + year;
        }   
    },
 
    render:function(){
        var photo;
        if(this.props.list.post.extra)
        { 
            photo= <Photo data= {this.props.list.post.extra}/>;

        }
        else{
            photo='';
        }
        return (
                    <div>
                            <div className="block-header ">
                            
                                <img className="img-avatar img-avatar32 pull-left" src={this.props.list.usermeta.propic} />
            	                <a href={"user/"+this.props.list.usermeta.username} style={{"marginLeft":"10px","marginTop":"10px"}}>
                                    <span className=" font-w700">{'  '+this.props.list.usermeta.Firstname+' '+this.props.list.usermeta.Lastname}</span>
                                </a>    
                                    <span className="inline pull-right">{this.timeToRelativeTime(this.props.list.post.created)}</span>
                            </div>
                        <div className="block-content">
                        <p style={{"marginTop":"-20px"}}>{this.props.list.post.content}</p>
                        {photo}
                            
                        </div> 
                    </div>
                    
		      );
	}

});

var Photo=React.createClass({

    render:function()
    {
        
            return(
                <div>
                    <img className="img-responsive" src={this.props.data} />
                </div>
            );

    }
})