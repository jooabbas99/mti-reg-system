<div class="row gutters attribute">
			<?php $page['record'] = $page;
			foreach($page['record'] as $key=>$val){
				?>
				<?php if(strtolower($val['type']) == 'radio(select one)'){
					$val['type'] = explode("(", $val['type']);
					$valueofattribute = json_decode($val['data'],true);
					?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<?php
					foreach($valueofattribute['attributevalue'] as $key=>$value){?>
						<div class="custom-control custom-radio custom-control-inline">
						<input type="<?php echo $val['type']['0']?>" id="<?php echo $val['slug'].'['.$key.']';?>" class="custom-control-input"  name="<?php echo $val['slug'];?>"  value="<?php echo $value ?>" <?php echo (isset($user['module'][$val['slug']]) && $value == $user['module'][$val['slug']]) || ($val['slug'] == $val) ?'checked':''; ?> />
						<label class="custom-control-label" for="<?php echo $val['slug'].'['.$key.']';?>" ><?php echo ucfirst($value)?></label>
						</div>
						<?php
					}?>
					</div>
					<?php }elseif(strtolower($val['type']) == 'checkbox(multiple select)'){
						$val['type'] = explode("(", $val['type']);
					$valueofattribute = json_decode($val['data'],true);?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<?php
					foreach($valueofattribute['attributevalue'] as $key=>$value){?>
						<?php
						if(isset($user['module'][$val['slug']]))
						if(!is_array($user['module'][$val['slug']])){
							$ar[0] = $user['module'][$val['slug']];
						}
						else{
							$ar = $user['module'][$val['slug']];
						}
						?>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input class="custom-control-input" type="<?php echo $val['type']['0']?>" id="<?php echo $val['slug'].'['.$key.']'?>" name="<?php echo $val['slug'];?>[]" value="<?php echo $value ?>" <?php echo (isset($user['module'][$val['slug']]) && in_array($value, $ar))|| ($val['slug'] == $val) ?'checked':''; ?>/>
							<label class="custom-control-label" for="<?php echo $val['slug'].'['.$key.']'?>"><?php echo $value?></label>
				
						</div>
						<?php
					}?>
					</div>
					<?php }elseif(strtolower($val['type']) == 'select(dropdown)'){
					?>
					<?php 
						$valueofattribute = json_decode($val['data'],true);
						?>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
							<select class="form-control" name="<?php echo $val['slug'];?>" id="<?php echo $val['name'	];?>" >
								<option value=" ">Choose Type:</option>
								<?php
								foreach($valueofattribute['attributevalue'] as $key=>$value){
									?>
								<option <?php echo (isset($user['module'][$val['slug']]) && $value == $user['module'][$val['slug']]) || ( $val['slug'] == $val) ?'selected':''; ?> value="<?php echo $value;?>"><?php echo $value;?></option>
								<?php
							}?>
							</select>
					</div>
				</div>
					<?php
				
				}elseif(strtolower($val['type']) == 'textarea(long field)'){
					?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
					<textarea class="form-control" placeholder="<?php echo ucfirst($val['name'])?>" name="<?php echo $val['slug']?>" role="textbox" aria-multiline="true"><?php echo (isset($user['module'][$val['slug']]))?$user['module'][$val['slug']]:''; ?></textarea>
					</div>
					</div>
					<?php
				}elseif(strtolower($val['type']) == 'file'){
					
				}else{
					$val['type'] = explode("(", $val['type']);
					if(isset($user['module'][$val['slug']])){
					if(is_array($user['module'][$val['slug']])){
							$ar = $user['module'][$val['slug']][0];
						}
						else{
							$ar = $user['module'][$val['slug']];
						}
					}
					?>
				
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
					<input type="<?php echo $val['type']['0']?>" class="form-control" id="<?php echo $val['slug'];?>" name="<?php echo $val['slug'];?>" placeholder="<?php echo ucfirst($val['name']);?> *" value="<?php echo (isset($user['module'][$val['slug']]))?$ar:''; ?>" />	
					</div>
				</div>
					<?php
					
				}
			}?>
						
		
		</div>