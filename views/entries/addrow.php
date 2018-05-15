 <tr>
                            <td>
                               <div class="form-group field-entryitems-<?= $key ?>-dc">

									<select id="<?php echo "entryitems-".$key."-dc"?>" class="dc-dropdown" name="<?php echo "Entryitems[".$key."][dc]" ?>">
									<option value="D">Dr</option>
									<option value="C">Cr</option>
									</select>

									<div class="help-block"></div>
								</div>                            
							</td>

                            <td>
                             <div class="form-group field-entryitems-<?= $key ?>-ledger_id">
                                  <select id="entryitems-<?= $key ?>-ledger_id" class="selectpicker ledger-dropdown" name="Entryitems[<?= $key ?>][ledger_id]" aria-invalid="false" data-live-search="true">

                                   <?php
                                    foreach ($ledger_options as $row => $data) {
                                        if ($row >= 0) 
                                        {
                                            if($row == 0)
                                                 echo '<option value="">' . $data . '</option>';
                                            else
                                                echo '<option value="' . $row . '">' . $data . '</option>';
                                        } else {
                                            echo '<option value="' . $row . '" disabled="disabled">' . $data . '</option>';
                                        }
                                    } ?>
                                   </select>
                                   <div class="help-block"></div>
                                </div>
                            
                            </td>
                            <td> 
                               <div class="form-group field-entryitems-<?= $key ?>-dr_amount">
                               		<input type="text" id="entryitems-<?= $key ?>-dr_amount" class="dr-amount" name="Entryitems[<?= $key ?>][dr_amount]" disabled="">

									<div class="help-block"></div>

                               </div>


                            </td>
                           <td> 
                               <div class="form-group field-entryitems-<?= $key ?>-cr_amount">
                               		<input type="text" id="entryitems-<?= $key ?>-cr_amount" class="cr-amount" name="Entryitems[<?= $key ?>][cr_amount]" disabled="">

									<div class="help-block"></div>

                               </div>


                            </td>
                            <td>
                                <div class="form-group field-entryitems-<?= $key ?>-cheque_no">
                               		<input type="text" id="entryitems-<?= $key ?>-cheque_no" class="cheque_no" name="Entryitems[<?= $key ?>][cheque_no]">

									<div class="help-block"></div>

                               </div>    

                            </td>

                            <td>
                               <div>
                               		<a class="btn btn-primary btn-sm addrow">ADD</a>
                                	<a class="btn btn-danger btn-sm deleterow">REMOVE</a>
                              	</div>
                               
                            </td>
                            <td>
                            </td>
                </tr>