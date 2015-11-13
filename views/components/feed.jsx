var Feed = React.createClass({

		
		render:function(){

		return(
			<div className="col-xs-12 col-sm-offset-3">
				<div className="content">

				

				{this.props.news.map(function (item) {
						
						return(
							<div>
						<Feeditem list={item} key={item.post.id} />
						</div>

						);
				})}
				</div>
			</div>
		);
	}
		
});

var Feeditem = React.createClass({

		render:function(){
				return(
					<div className="row">
						<div className="col-sm-6">
	                            <div className="block">
	                        
							<Status list={this.props.list} />
							
							<VoteLink list={this.props.list}/>
							
							<br/>
							<Comment list={this.props.list} />
							<CommentBox list={this.props.list} />
						</div>
	                    </div>
	                 </div>
				);
		
		}
});