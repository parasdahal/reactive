var Header= React.createClass({
    handleLogout: function(e)
    {
        e.preventDefault();
        $.ajax({
            url:'api/logout.php',
            success:function(response)
            {
                $(location).attr('href','login');
            }
        });
    },

	render:function(){


		var notifs=[
			{
				value:'You are great',
				link:'dsada'
			},
			{
				value:'This is awesome',
				link:'asdsda'
			}
		];
		return(

			<header id="header-navbar" className="content-mini content-mini-full">
                <ul className="nav-header pull-right">
                    <li>
                        <a href="home">Home</a>
                    </li>
                    <li>
                        <a href="profile">Profile</a>
                    </li>
                    <li>
                        <a onClick={this.handleLogout} href="#" >Logout</a>
                    </li>
                </ul>
                <ul className="nav-header center-block">
                    <li>
                    <h4>SocialPlus</h4>
                    </li>
                    
                </ul>
			</header>


			);
	}
});


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
