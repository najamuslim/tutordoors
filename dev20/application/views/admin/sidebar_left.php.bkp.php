	<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo ADMIN_LTE_DIR;?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('fn');?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div> -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
			<li class="treeview <?php echo ($am=='dashboard' ? 'active' : '');?>">
              <a href="<?php echo base_url('cms/dashboard'); ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="treeview <?php echo ($am=='base_setup' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-cogs"></i>
					Application Base Setup
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='master' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Master Data
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='province' ? 'active' : '');?>">
								<a href="<?php echo base_url('location/province');?>">
									<i class="fa fa-circle-o"></i>
									Province
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='city' ? 'active' : '');?>">
								<a href="<?php echo base_url('location/city');?>">
									<i class="fa fa-circle-o"></i>
									City
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='bank' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/setup_bank');?>">
									<i class="fa fa-circle-o"></i>
									Bank
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='company' ? 'active' : '');?>">
						<a href="<?php echo base_url('cms/set_options');?>">
							<i class="fa fa-circle-o"></i>
							Company Info
						</a>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='3rd_party' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Third Party
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='veritrans' ? 'active' : '');?>">
								<a href="<?php echo base_url('veritrans/setup');?>">
									<i class="fa fa-circle-o"></i>
									Veritrans
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='paypal' ? 'active' : '');?>">
								<a href="<?php echo base_url('paypal/setup');?>">
									<i class="fa fa-circle-o"></i>
									Paypal
								</a>
							</li>
	                    </ul>
					</li>
					<!-- <li class="<?php if(isset($asm_1)) echo ($asm_1=='miscellaneous' ? 'active' : '');?>">
						<a href="<?php echo base_url('cms/set_miscellaneous');?>">
							<i class="fa fa-circle-o"></i>
							Miscellaneous
						</a>
					</li> -->
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='otest' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Online Test
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='setup' ? 'active' : '');?>">
								<a href="<?php echo base_url('otest/setup');?>">
									<i class="fa fa-circle-o"></i>
									Variable Data
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='grade_setup' ? 'active' : '');?>">
								<a href="<?php echo base_url('otest/grade_setup');?>">
									<i class="fa fa-circle-o"></i>
									Tutor Grade
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='payroll' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Payroll
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='setup' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/setup');?>">
									<i class="fa fa-circle-o"></i>
									Variable Data
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='umk' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/setup_umk');?>">
									<i class="fa fa-circle-o"></i>
									Upah Minimum Kota
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='range_fee' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/setup_range_fee');?>">
									<i class="fa fa-circle-o"></i>
									Range Tutor Fee
								</a>
							</li>
	                    </ul>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='course_management' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-bookmark"></i>
					Course Management
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='setup' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Course Setup
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='program' ? 'active' : '');?>">
								<a href="<?php echo base_url('course/program');?>">
									<i class="fa fa-circle-o"></i>
									Program
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='module_tryout' ? 'active' : '');?>">
								<a href="<?php echo base_url('course/module_tryout');?>">
									<i class="fa fa-circle-o"></i>
									Set Modul &amp; Try-Out
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='order' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Course Order
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='open' ? 'active' : '');?>">
								<a href="<?php echo base_url('order/open_order_request');?>">
									<i class="fa fa-circle-o"></i>
									Open Request
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='rejected' ? 'active' : '');?>">
								<a href="<?php echo base_url('order/rejected');?>">
									<i class="fa fa-circle-o"></i>
									Rejected Course
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='enrollment' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Course Enrollment
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='running_course' ? 'active' : '');?>">
								<a href="<?php echo base_url('course/view_running_course');?>">
									<i class="fa fa-circle-o"></i>
									Running Course
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='completed_course' ? 'active' : '');?>">
								<a href="<?php echo base_url('course/admin_completed_course');?>">
									<i class="fa fa-circle-o"></i>
									Completed Course
								</a>
							</li>
	                    </ul>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='operational' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-retweet"></i>
					Operational
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='payroll' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Payroll
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='calculation' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/calculation_start');?>">
									<i class="fa fa-circle-o"></i>
									Calculation
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='finalization' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/finalization_start');?>">
									<i class="fa fa-circle-o"></i>
									Finalization
								</a>
							</li>
							<!-- <li class="<?php if(isset($asm_2)) echo ($asm_2=='checklist_payment' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/checklist_payment');?>">
									<i class="fa fa-circle-o"></i>
									Checklist Payment
								</a>
							</li> -->
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='history' ? 'active' : '');?>">
								<a href="<?php echo base_url('payroll/history');?>">
									<i class="fa fa-circle-o"></i>
									Payment Checklist
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='payment' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Payment
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='invoice' ? 'active' : '');?>">
								<a href="<?php echo base_url('invoice');?>">
									<i class="fa fa-circle-o"></i>
									Invoice
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='transfer_confirmation' ? 'active' : '');?>">
								<a href="<?php echo base_url('invoice/view_payment');?>">
									<i class="fa fa-circle-o"></i>
									Transfer Confirmation
								</a>
							</li>
							<li>
								<a href="https://account.veritrans.co.id/login" target="_blank">
									<i class="fa fa-circle-o"></i>
									Veritrans Payment
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='otest' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Online Test
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='setup' ? 'active' : '');?>">
								<a href="<?php echo base_url('otest/test_setup');?>">
									<i class="fa fa-circle-o"></i>
									Test Setup
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='tutor_assignment' ? 'active' : '');?>">
								<a href="<?php echo base_url('otest/tutor_assignment');?>">
									<i class="fa fa-circle-o"></i>
									Tutor Assignment
								</a>
							</li>
	                    </ul>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='messaging' ? 'active' : '');?> ">
				<a href="#">
					<i class="fa fa-envelope"></i>
					Text Messaging
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='live_chat' ? 'active' : '');?>">
						<a href="<?php echo base_url('lchat/admin');?>">
							<i class="fa fa-circle-o"></i>
							Live Chat
						</a>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='message_contact' ? 'active' : '');?>">
						<a href="<?php echo base_url('content/message_contact');?>">
							<i class="fa fa-circle-o"></i>
							Message on Contact Form
						</a>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='notification' ? 'active' : '');?>">
						<a href="<?php echo base_url('cms/show_notifications');?>">
							<i class="fa fa-circle-o"></i>
							Notification
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='users' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-users"></i>
					User Management
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='tutor' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Tutor
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='verified' ? 'active' : '');?>">
								<a href="<?php echo base_url('teacher/verified');?>">
									<i class="fa fa-circle-o"></i>
									Verified Tutor
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='unverified' ? 'active' : '');?>">
								<a href="<?php echo base_url('teacher/unverified');?>">
									<i class="fa fa-circle-o"></i>
									Unverified Tutor
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='request_course_thing' ? 'active' : '');?>">
								<a href="#">
									<i class="fa fa-circle-o"></i>
									Request
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php if(isset($asm_3)) echo ($asm_3=='city' ? 'active' : '');?>">
										<a href="<?php echo base_url('teacher/verification_request/city');?>">
											<i class="fa fa-circle-o"></i>
											City
										</a>
									</li>
									<li class="<?php if(isset($asm_3)) echo ($asm_3=='city_delete' ? 'active' : '');?>">
										<a href="<?php echo base_url('teacher/request_for_delete/city');?>">
											<i class="fa fa-circle-o"></i>
											City - Delete Request
										</a>
									</li>
									<li class="<?php if(isset($asm_3)) echo ($asm_3=='course' ? 'active' : '');?>">
										<a href="<?php echo base_url('teacher/verification_request/course');?>">
											<i class="fa fa-circle-o"></i>
											Course
										</a>
									</li>
									<li class="<?php if(isset($asm_3)) echo ($asm_3=='course_delete' ? 'active' : '');?>">
										<a href="<?php echo base_url('teacher/request_for_delete/course');?>">
											<i class="fa fa-circle-o"></i>
											Course - Delete Request
										</a>
									</li>
								</ul>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='student' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Student
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='verified' ? 'active' : '');?>">
								<a href="<?php echo base_url('student/verified');?>">
									<i class="fa fa-circle-o"></i>
									Verified Student
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='unverified' ? 'active' : '');?>">
								<a href="<?php echo base_url('student/unverified');?>">
									<i class="fa fa-circle-o"></i>
									Unverified Student
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='user_access' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								User Access
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='view_all' ? 'active' : '');?>">
								<a href="<?php echo base_url('users/user_view?v=all');?>">
									<i class="fa fa-circle-o"></i>
									View All
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='new' ? 'active' : '');?>">
								<a href="<?php echo base_url('users/add_user');?>">
									<i class="fa fa-circle-o"></i>
									Add new
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='change-password' ? 'active' : '');?>">
								<a href="<?php echo base_url('users/change_password_view');?>">
									<i class="fa fa-circle-o"></i>
									Change Password
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='subscriber' ? 'active' : '');?>">
						<a href="<?php echo base_url('users/subscribers');?>">
							<i class="fa fa-circle-o"></i>
							Newsletter Subscriber
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='media' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-file-o"></i>
					Article &amp; Media
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='post' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Post
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='view_all' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/view_post?ty=post');?>">
									<i class="fa fa-circle-o"></i>
									View All
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='new' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/post_new');?>">
									<i class="fa fa-circle-o"></i>
									Add new
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='view_category' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/category_view?ty=post');?>">
									<i class="fa fa-circle-o"></i>
									Category
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='page' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Page
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
		                    <li class="<?php if(isset($asm_2)) echo ($asm_2=='view_all' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/view_post?ty=page');?>">
									<i class="fa fa-expand"></i>
									View All
								</a>
							</li>
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='new' ? 'active' : '');?>">
								<a href="<?php echo base_url('cms/page_new');?>">
									<i class="fa fa-expand"></i>
									Add New
								</a>
							</li>
	                    </ul>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='faq' ? 'active' : '');?>">
						<a href="<?php echo base_url('cms/faq');?>">
							<i class="fa fa-circle-o"></i>
							FAQ
						</a>
					</li>
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='media' ? 'active' : '');?>">
						<a href="<?php echo base_url('cms/media_view_all');?>">
							<i class="fa fa-circle-o"></i>
							Media
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='appearance' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-adjust"></i>
					Appearance
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='menu' ? 'active' : '');?>">
						<a href="#">
							<i class="fa fa-circle-o"></i>
								Menu
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(isset($asm_2)) echo ($asm_2=='second_top' ? 'active' : '');?>">
								<a href="<?php echo base_url('content/second_top_menu');?>">
									<i class="fa fa-circle-o"></i>
									Second Top Menu
								</a>
							</li>
	                    </ul>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($am=='event' ? 'active' : '');?>">
				<a href="#">
					<i class="fa fa-adjust"></i>
					Events
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if(isset($asm_1)) echo ($asm_1=='jobfair' ? 'active' : '');?>">
						<a href="<?php echo base_url('event/jobfair_report') ?>">
							<i class="fa fa-circle-o"></i>
								Job Fair
						</a>
					</li>
				</ul>
			</li>
			
            <li><a href="<?php echo base_url();?>users/do_logout"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
		
          <!-- /.sidebar menu -->
		  
        </section>
        <!-- /.sidebar -->
      </aside>