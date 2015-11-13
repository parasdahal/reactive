var Badge=React.createClass({

	loadFeedFromServer: function() {
	    $.ajax({
	      url: 'api/userbadge.php',
	      dataType: 'json',
	      cache: false,
	      
	      success: function(data) {
	        this.setState({data: data});
	        console.log(data);
	      }.bind(this),

	      error: function(xhr, status, err) {
	      
	      console.error(this.props.url, status, err.toString());
	      }.bind(this)
	    });
	  },

  	  getInitialState: function() {
	    return {data: []};
	  },

	  componentDidMount: function() {
	    this.loadFeedFromServer();
	  },

	  render:function()
		{	
			return(
				<div>
				<div className="col-xs-12 col-sm-offset-3">
				<div className="content">
					<div className="row">
						<div className="col-sm-6">
	                            
						<BadgeItem data={this.state.data} />
						
					</div>
					</div>
				</div>
				</div>
				</div>
			);
		}


});

var BadgeItem = React.createClass({

		render:function(){
			console.log(this.props.data.propic);
				return(
					<div>

                        <img className="img-avatar pull-left " src={this.props.data.propic} />

                            <h1 className="page-heading pull-left" style={{"marginLeft":"30px"}}>
                                {this.props.data.fullname}
                            </h1><br/><br/>
                            <span style={{"marginLeft":"30px"}}>{this.props.data.bio}</span><br/><br/>
                            <span style={{"marginTop":"50px","marginLeft":"0px"}}><b>{this.props.data.followers}</b> Followers <b>{this.props.data.following}</b> Following </span>
                        </div>

			);
		
		}
});