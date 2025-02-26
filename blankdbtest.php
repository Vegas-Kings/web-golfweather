					<datalist id="counties">
					<?php
						$getQuery = "select name from countries where continent='AF' order by name";
						$getQueryRes = mysqli_query($db,$getQuery);
						$countNumD = mysqli_num_rows($getQueryRes);
						if ($countNumD > 0){
							$getRes = mysqli_fetch_array($getQueryRes);
							$i=0;
							while($i < $countNumD){
					?>
					    <option value="<?php echo $getRes['name'];?>"><?php echo $getRes['name'];?></option>
					<?php
		
								$i++;
								$getRes = mysqli_fetch_array($getQueryRes);
							}
						}
						mysqli_free_result($getQueryRes);
					?>
					</datalist>
					<input type="text" class="dropTxt" list="counties" title="county-selector" id="county-selector" value="South Africa" placeholder="Start Typing">					
