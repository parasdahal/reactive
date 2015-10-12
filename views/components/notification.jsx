
var NotificationItem = React.createClass({
	render:function(){
		return (
			<li>
				<a className="bg-gray-lighter" tabIndex="-1" href={this.props.link}>
				{this.props.children}
				</a>
			</li>        
		);
	}

});

var Notifications = React.createClass({

	render:function(){


		return(
			<div>
                 {this.props.list.map(function (notif){
                 	 return (

                 	 	<NotificationItem link={notif.link} key={notif.link}>{notif.value}</NotificationItem>
                 	 
                 	 );

                 })}
            </div>
		);
	}
});
