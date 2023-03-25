<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
      <?php
    }
    ?>
    

    
    
      
    
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <?php $this->load->view('html/v_header.php'); ?>
      <!--header end-->
      <!--sidebar start-->
      <?php $this->load->view('html/v_sidebar.php'); ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-map-marker"></i> Operator Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Operator Details
                            </header>
                            
                            <div class="panel-body">
                                <?php
                                if($this->session->flashdata('warning'))
                                {
                                  ?>
                                  <div class="alert alert-warning fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                                  </div>
                                  <?php
                                }                                  
                                if($this->session->flashdata('error'))
                                {
                                  ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                                </div>
                                  <?php
                                }
                                if($this->session->flashdata('success'))
                                {
                                  ?>
                                  <div class="alert alert-success alert-block fade in">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="icon-remove"></i>
                                      </button>
                                      <h4>
                                          <i class="icon-ok-sign"></i>
                                          Success!
                                      </h4>
                                      <p><?=$this->session->flashdata('success'); ?></p>
                                  </div>
                                  <?php
                                }
                                if(isset($operator_id))
                                {
                                  $operator_values = $this->m_masters->getmasterdetails('dyn_operators', 'operator_id', $operator_id);
                                  foreach ($operator_values as $values) {
                                    $operator_id = $values['operator_id'];
                                    $op_name=$values['op_name'];
                                    $op_nick_name=$values['op_nick_name'];
                                    $op_father_name=$values['op_father_name'];
                                    $op_address=$values['op_address'];
                                    $op_refered_by=$values['op_refered_by'];
                                    $op_doj=$values['op_doj'];
                                    $op_spd=$values['op_spd'];
                                    $op_concern=$values['op_concern'];
                                  }
                                  $contact_details=$this->m_mir->get_two_table_values('dyn_operator_contact','','*','','',array(
                                      'operator_id'=>$operator_id, 
                                      'is_deleted'=>1
                                  ));
                                  $contacts=array();
                                  $designation=array();
                                  foreach ($contact_details as $val) {
                                    $contacts[]=$val['op_contact_number'];
                                    $designation[]=$val['op_relation'];
                                  }
                                  if(empty($contacts)){
                                    $contacts=array(0=>'');
                                  }
                                  if(empty($designation)){
                                    $designation=array(0=>'');
                                  }
                                }
                                else
                                {
                                  $contacts=array(0=>'');
                                  $designation=array(0=>'');
                                  $operator_id = '';
                                  $op_name='';
                                  $op_nick_name='';
                                  $op_father_name='';
                                  $op_address='';
                                  $op_refered_by='';
                                  $op_doj='';
                                  $op_spd='';
                                  $op_concern='';
                                }
                                ?>                             
                                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/save_operator">
                                  <?php if ($operator_id):?>
                                  <div class="form-group col-lg-1">
                                     <label for="operator_id">ID</label>
                                     <input type="text" class="form-control" name="operator_id" value="<?=$operator_id;?>" readonly>
                                    </div>
                                  <?php endif;?>
                                  <div class="form-group col-lg-3">
                                     <label for="item_name">Concern Name</label>
                                     <select class="form-control select2" name="op_concern">
                                        <option value="">Select Concern</option>
                                        <?php
                                        foreach ($concerns as $row) {
                                           ?>
                                           <option value="<?=$row['concern_id'];?>" <?=($row['concern_id'] == $op_concern)?'selected="selected"':''; ?>><?=$row['concern_name'].$row['concern_id'];?></option>
                                           <?php
                                        }
                                        ?>
                                     </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_name">Operator Name</label>
                                     <input type="text" class="form-control" name="op_name" value="<?=$op_name;?>" required>
                                    </div>
                                    <div class="form-group col-lg-2">
                                     <label for="operator_nick_name">Nick Name</label>
                                     <input type="text" class="form-control" name="op_nick_name" value="<?=$op_nick_name;?>" required>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_father_name">Father Name</label>
                                     <input type="text" class="form-control" name="op_father_name" value="<?=$op_father_name;?>" required>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_address">Home Address</label>
                                     <input type="text" class="form-control" name="op_address" value="<?=$op_address;?>" required>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_refered_by">Refered By</label>
                                     <input type="text" class="form-control" name="op_refered_by" value="<?=$op_refered_by;?>" required>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_doj">Date Of Join</label>
                                     <input type="date" class="form-control" name="op_doj" value="<?=$op_doj;?>" required>
                                    </div>
                                    <div class="form-group col-lg-3">
                                     <label for="op_spd">Salary Per Day</label>
                                     <input type="text" class="form-control" name="op_spd" value="<?=$op_spd;?>" required>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="form-group col-lg-11" id="contacts">
                                      <div class="form-group col-lg-12">
                                        <div class="col-lg-3">
                                          <label for="designation">Designation</label>
                                        </div>
                                        <div class="col-lg-3">
                                          <label for="phone_number">Phone Number</label>
                                        </div>
                                      </div>
                                      <?php
                                      foreach ($contacts as $key => $value) {
                                        ?>
                                        <div class="form-group col-lg-12 contactsrow">
                                            <div class="col-lg-3">
                                              <input class="form-control" value="<?=$designation[$key]; ?>"  name="designation[]" type="text" >
                                            </div>
                                            <div class="col-lg-3">
                                              <input class="form-control" value="<?=$value; ?>"  name="phone_number[]" type="text">
                                            </div>
                                            <?php
                                            if($key == 0)
                                            {
                                              ?>
                                              <button type="button" class="btn btn-primary addrow"><i class="icon-plus"></i> Add</button>
                                              <?php
                                            }
                                            else
                                            {
                                              ?>
                                              <button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button>
                                              <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                      }
                                      ?>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="form-group col-lg-12">
                                        <div>
                                            <button class="btn btn-danger" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Concern Name</th>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Nick Name</th>
                                  <th>Father Name</th>
                                  <th>Address</th>
                                  <th>Contact Details</th>
                                  <th>Salary Per Day</th>
                                  <th>Date Of Join</th>
                                  <th>Refered By</th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($operators as $operator) {
                                $concern_name=$this->m_masters->getmasterIDvalue('bud_concern_master','concern_id',$operator['op_concern'],'concern_name');
                                $contact_details=$this->m_mir->get_two_table_values('dyn_operator_contact','','*','','',array(
                                      'operator_id'=>$operator['operator_id'], 
                                      'is_deleted'=>1
                                  ));
                                $contact='';
                                foreach ($contact_details as $val) {
                                  $contact.=$val['op_relation'].' - '.$val['op_contact_number'].'</br>';
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$concern_name; ?></td>
                                    <td><?=$operator['operator_id']?></td>
                                    <td><?=$operator['op_name']?></td>
                                    <td><?=$operator['op_nick_name']?></td>
                                    <td><?=$operator['op_father_name']?></td>
                                    <td><?=$operator['op_address']?></td>
                                    <td><?=$contact?></td>
                                    <td><?=$operator['op_spd']?></td>
                                    <td><?=$operator['op_doj']?></td>
                                    <td><?=$operator['op_refered_by']?></td>
                                    <td>
                                      <a href="<?=base_url();?>masters/operators/<?=$operator['operator_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateId(<?=$operator['operator_id']?>)">Delete
                                      </button>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                      </section>
                    </div>
                </div>     
                <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Entry</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" id="entryId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Typing Mistake">Typing Mistake</label>
            </div>       
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="WrongQty" value="System Error">System Error</label>
            </div>
            <div class="radio">
              <label><input type="radio" name="remarks" id='others' value="others">Others</label>
            </div>
            <div class="form-group" id="otherRemarks">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="5" name="others" id="otherRemarkValue"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deleteEntry()">Delete</button>
          </div>
        </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>    

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(function() {
        var scntDiv = $('#contacts');
        var i = $('#contacts .contactsrow').size() + 1;
        $( ".addrow" ).live( "click", function() {
          var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control"  name="designation[]" type="text"></div><div class="col-lg-3"><input class="form-control"  name="phone_number[]" type="text"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
          $(nextrow).appendTo(scntDiv);        
          i++;
          return false;
          alert( i ); // jQuery 1.3+
        });
        $('.removerow').live('click', function() {
          if( i > 2 ) {
              $(this).parents('#contacts .contactsrow').remove();
              i--;
          }
          return false;
        });
      }); 

  </script>
  <script>
      $('#otherRemarks').hide();
      $('#others').click(function(event) {
      if(this.checked) { // check select status
        $('#otherRemarks').show();
      }
      else
      {
        $('#otherRemarks').hide();
      }
      });
      $('.remarks').click(function(event) {
      $('#otherRemarks').hide();
      });
      function updateId(id){
        $('#entryId').val(id);
      }
      function deleteEntry(){
        var remarks = $( "input:checked" ).val();
        if(remarks=="others")
        {
          remarks=$('#otherRemarkValue').val();
        }
        var id=$('#entryId').val();
        var url = "<?php echo base_url('masters/operator_delete')?>";
        $.ajax({
            type: "POST",
            url: url,
            data:  {
            "id": id,
            "remarks": remarks
            },
            success: function(result)
            {
              alert(result);
              location.reload(true);
            }
          });
      }
      </script>
  </body>
</html>
