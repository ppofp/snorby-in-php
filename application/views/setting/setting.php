<div class="container">
			<div class="tabbable tabs-left" style="height:600px">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#database" data-toggle="tab">数据库状态</a></li>
                <li class=""><a href="#system" data-toggle="tab">系统配置</a></li>
                <li class=""><a href="#useraccount" data-toggle="tab">用户帐户</a></li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane active" id="database">
                  <a class="btn btn-success refreshDemonEvent">刷新demon_event表</a>
                </div>
                <div class="tab-pane" id="system">
                  <h1>还没开始做噢~~</h1>
                </div>
                <div class="tab-pane" id="useraccount">

			        <form id="tab" method="POST" action="<?php echo site_url('setting/update_password');?>" >
			            <strong>用户名：</strong><?php echo $user['name'];?><br/><br/>
			       		<input type="text" value="<?php echo $user['name'];?>" name="username" style="display:none" />
			            <div class="input-prepend">
						  <span class="add-on"><strong>初始密码：</strong></span>
						  <input class="span2" type="password" name="ori_pass">
						</div>
						<br/>
			            <div class="input-prepend">
						  <span class="add-on"><strong>修改密码：</strong></span>
						  <input class="span2" type="password" name="new_pass">
						</div>
						<br/>
			            <div class="input-prepend">
						  <span class="add-on"><strong>确认密码：</strong></span>
						  <input class="span2" type="password" name="new_pass_verify">
						</div>
						<br/>
			          	<div>
			        	    <button class="btn btn-success">更新</button>
			        	</div>
			        </form>

  				</div>
                  
                </div>
              </div>
</div>