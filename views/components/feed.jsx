var Feed = React.createClass({

		
		render:function(){

		return(
			<div className="col-xs-12 col-sm-offset-3">
				<div className="content">

				{this.props.news.map(function (item) {
						
						return(

						<Status list={item} key={item.post.id} />

						)
				})}
				</div>
			</div>
		);
	}
		
});