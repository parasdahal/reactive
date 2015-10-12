var Header= React.createClass({

	render:function(){


		var notifs=[
			{
				value:'You are great',
				link:'dsada'
			},
			{
				value:'This is awesome',
				link:'asdsda'
			}
		];
		return(

			<header id="header-navbar" className="content-mini content-mini-full">
                <ul className="nav-header pull-right">
                    <li>
                        <div className="btn-group">
                            <button className="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                <i className="si si-bell"></i>
                            </button>
                            <ul className="dropdown-menu dropdown-menu-right">
                                <li className="dropdown-header">Notifications</li>
                                
                            	<Notifications list={notifs} />

                            </ul>
                        </div>
                    </li>
                </ul>
                <ul className="nav-header center-block">
                    <li>
                    <h4>SocialPlus</h4>
                    </li>
                    <li className="header-search pull-right">
                        <form className="form-horizontal" action="" method="post">
                            <div className="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                                <input className="form-control" type="text" id="base-material-text" name="base-material-text" placeholder="Search.."/>
                                <span className="input-group-addon"><i className="si si-magnifier"></i></span>
                            </div>
                        </form>
                    </li>
                </ul>
			</header>


			);
	}
});