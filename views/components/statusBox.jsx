var StatusBox = React.createClass({

		handleStatusSubmit: function(e) {
			
			e.preventDefault();

			var status=React.findDOMNode(this.refs.statustext).value.trim();
			if(status!='')
			{
				$.ajax({
					url:'api/poststatus.php',
					type:'POST',
					data:{'status':status},
					success:function(data){
						
					}

				});
			}
			React.findDOMNode(this.refs.statustext).value='';
			
			return;
		},
		handlePhotoSubmit: function(e) {
			
			e.preventDefault();

			var status=React.findDOMNode(this.refs.phototext).value.trim();

			var path;
			$("#uploadstatus").html("Uploading...")
			var file_data = $('#uploader').prop('files')[0];   
    		var form_data = new FormData();                  
    		form_data.append('file', file_data);                        
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
								url:'api/poststatus.php',
								type:'POST',
								data:{'status':status,'extra':path},
								success:function(data){
									console.log(data);
								}
							});
                		}
                    
             	}
     		});
			
			React.findDOMNode(this.refs.phototext).value='';
			
			return;
		},

		photoToggle:function(e)
		{
			e.preventDefault();
			$("#statusform").slideToggle();
			$("#photoform").slideToggle();
			$('#photolink').html($("#photolink").text()=="Post Photo"?"Post Status":"Post Photo");
		},

		render:function(){

			return(
				<div className="col-xs-6 col-sm-offset-3">
				<div className="content">
				<div className="block-content bg-white">
				<div className="row">
						<div style={{"padding":"20px"}}>
	                            <div className="block">
				 	<button className="btn btn-minw btn-rounded btn-default" type="button" id="photolink" style={{"marginBottom":"20px"}}href="" onClick={this.photoToggle} >Post Photo</button>
				 	<form id="statusform" className="form-horizontal" method="post" onSubmit={this.handleStatusSubmit} >
	                       
	                          <input className="form-control input-lg" ref="statustext" type="text" id="mega-firstname" placeholder="Tell the world what you're upto.."/>
                              <button className="js-notify btn btn-primary push-5-r push-10" type="submit" data-notify-type="success" data-notify-align="center" data-notify-icon="fa fa-check" data-notify-message="App was updated successfully to 1.2 version"><i className="fa fa-plus push-5-r"></i> Post</button>
                            
		            </form>
		            <br/>
		            <form id="photoform" style={{"display":"none"}} className="form-horizontal" method="post" onSubmit={this.handlePhotoSubmit} >
	                	<input id="uploader" type="file" name="sortpic" /><span id="uploadstatus"></span>
						<br/>
						<input className="form-control input-lg" ref="phototext" type="text" id="mega-firstname" placeholder="A little about the picture..."/>
						
						<button className="btn btn-primary push-5-r push-10" id="upload" type="submit"><i className="fa fa-upload"></i> Upload</button>
						
   					</form>
	                  
	                  </div>
	                 </div>
	                 </div>
	                 </div>
	                 </div>
	                 </div>
                   
                  

			);
		}

});