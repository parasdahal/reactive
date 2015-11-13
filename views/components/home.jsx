
var Home=React.createClass({
	  
	  loadFeedFromServer: function() {
	    $.ajax({
	      url: 'api/userfeed.php',
	      dataType: 'json',
	      cache: false,
	      
	      success: function(data) {
	        this.setState({data: data});
	      }.bind(this),

	    });
	  },

	  getInitialState: function() {
	    return {data: []};
	  },

	  componentDidMount: function() {
	    this.loadFeedFromServer();
	    setInterval(this.loadFeedFromServer, 1000);
	  },
		
		render:function()
		{	
			return(
				<div>
					<Header/>
					<StatusBox data={this.state.data} />
					<Feed news={this.state.data}/>
				</div>
			);
		}

});