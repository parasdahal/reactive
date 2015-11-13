
var User=React.createClass({
	  
	  loadFeedFromServer: function() {
	  	var id=this.props.id;
	    $.ajax({
	      url: 'api/userprofile.php',
	      type:'POST',
		  data:{'id':id},
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
	    setInterval(this.loadFeedFromServer, 3000);
	  },
		
		render:function()
		{	
			return(
				<div>
					<Header/>
					<Badge/>
					<Feed news={this.state.data}/>
				</div>
			);
		}

});