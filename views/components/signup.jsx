var SignupBox = React.createClass({
	

	handleSignupSubmit:function(e)
	{
		
		e.preventDefault();
		var username=React.findDOMNode(this.refs.username).value;
		var password=React.findDOMNode(this.refs.password).value;
		var email=React.findDOMNode(this.refs.email).value;

				$.ajax({
					url:'api/signup.php',
					type:'POST',
					data:{
						'username':username,
						'password':password,
						'email':email
					},
					success:function(msg){
						var array;
						try{
							array=JSON.parse(msg);
							$('#alert').addClass("alert alert-danger alert-dismissable");
							$('#alert').html("");
							array.forEach(function(item){
								$('#alert').append(item+"<br/>");
							});
						}catch (e)
						{
							console.log(msg);
							$('#alert').removeClass("alert-danger");
							$('#alert').addClass("alert-success alert-dismissable alert");
							$('#alert').html("Congrats you have successfully created an account!<br/><br/>Now complete your profile!");
							$('#signupform').slideToggle();
							$('#metaform').slideToggle();
						}
							
						
					}
						
                      
				});
			
			return;
	},

	handleMetaSubmit:function(e)
	{
		e.preventDefault();
		$("#uploadstatus").html("Uploading...");

        var username=React.findDOMNode(this.refs.username).value;
		var firstname=React.findDOMNode(this.refs.firstname).value;
		var lastname=React.findDOMNode(this.refs.lastname).value;
		var bio=React.findDOMNode(this.refs.bio).value;
		var path;
        
        var file_data = $('#uploader').prop('files')[0];   
        var form_data = new FormData(); 
        $.ajax({
                url: 'api/upload.php', 
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    if(response==0)
                        console.log(response);
                    else
                        {
                            $("#uploadstatus").html("");
                            path=response;
                            console.log(path);
                                $.ajax({
                                    url:'api/signup.php',
                                    type:'POST',
                                    data:{
                                        'username':username,
                                        'firstname':firstname,
                                        'lastname':lastname,
                                        'bio':bio,
                                        'propic':path
                                    },
                                    success:function(msg){
                                            $('#alert').removeClass("alert-danger");
                                            $('#alert').addClass("alert-success alert-dismissable alert");
                                            $('#alert').html("Congrats, your signup is complete! You can login <a href='login'>here</a>.");
                                            
                                        }
                                        
                                     
                              });
                            
                        }
                    
                }
            });	
			
			return;
	},


	render:function()
	{
		return(

			        
        <div className="content overflow-hidden">
            <div className="row">
                <div className="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                   
                    <div className="block block-themed animated fadeIn">
                        
                        <div className="block-content block-content-full block-content-narrow">
                            
                            <h1 className="h2 font-w600 push-30-t push-5">SocialPlus</h1>
                            <p>Welcome, please fill the following information.</p>
                           
                            <div id="alert" className=""></div>
                            <form id="signupform" className="js-validation-login form-horizontal push-30-t push-50" action="api/login.php" method="POST" onSubmit={this.handleSignupSubmit}>
                                
                                
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                            <input className="form-control" type="email" id="login-email" ref="email" name="username" />
                                            <label for="login-username">Email</label>
                                        </div>
                                    </div>
                                </div>
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
                                        <button className="btn btn-block btn-primary" type="submit"><i className="si si-login pull-right"></i> Sign Up</button>
                                    </div>
                                </div>
                            </form>

                            <form id="metaform" style={{"display":"none"}} className="js-validation-login form-horizontal push-30-t push-50" action="api/login.php" method="POST" onSubmit={this.handleMetaSubmit}>
                                <div id="alert"></div>
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                            <input className="form-control" type="text" id="login-firstname" ref="firstname" name="username" />
                                            <label for="login-username">First Name</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                            <input className="form-control" type="text" id="login-lastname" ref="lastname" name="username" />
                                            <label for="login-username">Last Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                            <input className="form-control" type="textarea" id="login-lastname" ref="bio" name="username" />
                                            <label for="login-username">Bio</label>
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <div className="col-xs-12">
                                        <div className="form-material form-material-primary">
                                        <input className="form-control" id="uploader" type="file" name="sortpic" /><span id="uploadstatus"></span>
                                            <label for="login-username">Profile Picture</label>
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <div className="col-xs-12 col-sm-6 col-md-4">
                                        <button className="btn btn-block btn-primary" type="submit"><i className="si si-login pull-right"></i> Finish</button>
                                    </div>
                                </div>
                             </form>
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
  
        </div>
        


			

			);
	}

});;