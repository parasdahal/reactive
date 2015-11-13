
var VoteLink =React.createClass({

	handleClick: function(e) {
			
			e.preventDefault();
			
			var ownerid=this.props.list.post.user_id;
			var postid=this.props.list.post.id;
				$.ajax({
					url:'api/vote.php',
					type:'POST',
					data:{
						'ownerid':ownerid,
						'postid':postid
					},
					success:function(msg){
						
					console.log(msg);
					}

				});			
			return;
		},

	render:function () {
		
		return(
			<div className="bg-gray-lighter" style={{"padding":"20px"}}>

					<a href="#" style={{"marginLeft":"5px","marginTop":"-20px"}} onClick={this.handleClick} ref="vote"><i ref="voteicon" className="fa fa-heart-o " style={{"fontSize":"20px"}}></i></a>
					{this.props.list.votes.map(function (item) {
						
						return(

							
								<a href={"user/"+item.usermeta.username} style={{"marginLeft":"20px","marginTop":"-30px"}}>
                                    <span className=" font-w700">{item.usermeta.Firstname+' '+item.usermeta.Lastname}</span>
                                </a>    
                               
								
							
						);
				})}
				</div>
		);
	}
});
