var Comment= React.createClass({

	render:function()
	{	
		return(
			<div className="list list-timeline pull-t" style={{"marginLeft":"-80px"}}>
				
				{this.props.list.comments.map(function (item) {
						
						return(
 
							<div className="list-timeline-content block-content" style={{"marginLeft":"-30px","marginTop":"5px"}}>
							
								<p className="">
								<img className="img-avatar img-avatar32 pull-left" src={item.usermeta.propic} />
								<a href={"user/"+item.usermeta.username} style={{"marginLeft":"10px","marginTop":"10px"}}>
                                    <span className=" font-w700 inline">{item.usermeta.Firstname+' '+item.usermeta.Lastname}</span>
                                </a>    
                               <br/><span style={{"margin":"10px"}}>
								{item.comment}</span></p>
							</div>
						);
				})}

			</div>

			);
	}

});

var CommentBox =React.createClass({

	handleSubmit: function(e) {
			
			e.preventDefault();

			var comment=React.findDOMNode(this.refs.commenttext).value;
			
			var ownerid=this.props.list.post.user_id;
			var postid=this.props.list.post.id;
			if(comment!='')
			{
				$.ajax({
					url:'api/postcomment.php',
					type:'POST',
					data:{
						'comment':comment,
						'ownerid':ownerid,
						'postid':postid
					},
					success:function(msg){}

				});
			}
			React.findDOMNode(this.refs.commenttext).value='';
			
			return;
		},

	render:function () {
		
		return(
			<div >
					<form className="form-horizontal" style={{"padding":"20px","marginTop":"-20px"}} method="post" onSubmit={this.handleSubmit} >
	                                
	                          <input className="form-control input" ref="commenttext" type="text"  placeholder="Add a comment.."/>
                              
                                    
	                    </form>
	            </div>
		);
	}
});
