
var Home=React.createClass({
	  
	  loadCommentsFromServer: function() {
	    $.ajax({
	      url: 'api/userfeed.php',
	      dataType: 'json',
	      cache: false,
	      
	      success: function(data) {
	        this.setState({data: data});
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
	    this.loadCommentsFromServer();
	    setInterval(this.loadCommentsFromServer, 2000);
	  },
		
		render:function()
		{	
			return(
				<div>
					<Header/>
					<Feed news={this.state.data}/>
				</div>
			);
		}

});