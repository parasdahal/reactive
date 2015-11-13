var LoginBox = React.createClass({

	handleSubmit:function(e)
	{
		e.preventDefault();
		var username=React.findDOMNode(this.refs.username).value;

		var password=React.findDOMNode(this.refs.password).value;

				$.ajax({
					url:'api/login.php',
					type:'POST',
					data:{
						'username':username,
						'password':password
					},
					success:function(msg){
						if(msg==1)
							$(location).attr('href','home');
						// else{

      //                       $('#alert').html('<div className="alert alert-danger alert-dismissable" /><button type="button" className="close" data-dismiss="alert" aria-hidden="true">&times;</button><h3 className="font-w300 push-15">Error</h3><p> '+msg+' </p></div>');
						// 	console.log(msg);
      //                   }
					}

				});
			
			React.findDOMNode(this.refs.username).value='';

			React.findDOMNode(this.refs.password).value='';
			
			return;
	},

    signup:function(e)
    {
        e.preventDefault();
        $(location).attr('href','signup');
    },
	render:function()
	{
		return(

		<div>	        

        <div className="content overflow-hidden">
            <div className="row">
                <div className="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                   
                    <div className="block block-themed animated fadeIn">
                        
                        <div className="block-content block-content-full block-content-narrow">
                            
                            <h1 className="h2 font-w600 push-30-t push-5">SocialPlus</h1>
                            <p>Welcome, please login.</p>
                           

                            <form className="js-validation-login form-horizontal push-30-t push-50" action="api/login.php" method="POST" onSubmit={this.handleSubmit}>
                                <div id="alert"></div>
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                            <input className="form-control" type="text" id="login-username" ref="username" name="username" />
                                            <label for="login-username">Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary ">
                                            <input className="form-control" type="password" ref="password" name="password"/>
                                            <label for="login-password">Password</label>
                                        </div>
                                    </div>
                                </div>
                        
                                <div className="form-group">
                                    <div className="col-xs-12 col-sm-6 col-md-4">
                                        <button className="btn btn-block btn-primary" type="submit"><i className="si si-login pull-right"></i> Log in</button>
                                    </div>
                                </div>
                                Or signup for a new account.<hr/>
                                
                            </form>
                            <form className="form-horizontal" action="signup">
                            <div className="form-group">
                                    <div className="col-xs-12 ">
                                        <button className="btn btn-block btn-primary" type="submit"><i className="fa fa-plus pull-right" ></i> Signup</button>
                                </div>
                                </div>
                            </form>
                            
                        </div>

                    </div>
                    
                </div>

            </div>
  
        </div>
        
        </div>

			

			);
	}

});;