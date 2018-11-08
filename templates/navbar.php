<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
								    Profile
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="changepassword.php">Change Password</a></li>
                                <?php
                                if(isset($_SESSION[$adminToken]))
                                {
                                ?>
                                <li><a href="newuser.php">Add new user</a></li>
                                <li class="divider"></li>
                                <li><a href="mailto:shahid.sm35@gmail.com?subject=System Error Report From Kazi Mobile Home" target="_blank">Report System Problem</a></li>
                                <?php
                                 } // End if 
                                 else
                                 {
                                    echo '<li><a href="submitreport.php">Submit Report</a></li>';
                                 }
                                ?>
                                <li class="divider"></li>
                                <li><a href="logout.php">Log Out</a></li>
                              </ul>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>