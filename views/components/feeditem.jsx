var Feeditem = React.createClass({

		render:function(){

				return(
					<div>
						<Status list={this.props.item} />
					</div>
				);
		
		}
});