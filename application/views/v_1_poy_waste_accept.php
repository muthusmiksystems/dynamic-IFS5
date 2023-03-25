<?php include APPPATH.'views/html/header.php'; ?>
      <section id="main-content">
          <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-user"></i> Wastage POY Acceptance</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Talbe List  --> 
                      <?php
                      /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
                      ?>                                     <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Issue To</th>
                                <th>Supplier Group</th>
                                <th>Supplier</th>
                                <th>POY Denier</th>
                                <th>POY Lot</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Date</th>
								                <th>Wastage</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($poy_issue as $row) {
                              $id = $row['id'];
                              $is_accepted = $row['wpoy_status'];
                              if($id != '' && $is_accepted != 0 )
                              {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['item_name']; ?></td>                                                             <td><?=$row['item_id']; ?></td>                                                             <td><?=$row['dept_name']; ?></td>                                                             <td><?=$row['group_name']; ?></td>                                                             <td><?=$row['sup_name']; ?></td>
                                    <td><?=$row['denier_name']; ?></td>
                                    <td><?=$row['poy_lot_name']; ?></td>
                                    <td><?=$row['qty']; ?></td>
                                    <td><?=$row['uom_name']; ?></td>
                                    <td><?=$row['issue_datetime']; ?></td>
									                  <td><?=$row['wastage_kg']; ?></td>
                                    <td>
                                        <?php if($is_accepted == 2): ?>
                                          <label class="label label-success">Accepted</label>
                                        <?php endif; ?>
                                        <?php if($is_accepted == 1): ?>
                                          <!-- <a href="#<?php echo $row['id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Click to Accept" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Accept</a> -->
                                          <button onclick="showAjaxModal('<?php echo base_url('poy/confirm_wpoy_accept/'.$row['id']); ?>')" class="btn btn-xs btn-danger">Click To Accept</button>
                                        <?php endif; ?>                                                                  </td>
                                </tr>
                                <?php                                                      }
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
                    <!-- End Talbe List  -->                               </div>
                </div>             <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>

  <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm Accept</h4>
                </div>
                        <div class="modal-body" style="height:250px; overflow:auto;">
                            </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php include APPPATH.'views/html/footer.php'; ?>

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


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      function showAjaxModal(url)
      {
          // SHOWING AJAX PRELOADER IMAGE
          jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');
            // LOADING THE AJAX MODAL
          jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
          $.ajax({
              url: url,
              success: function(response)
              {
                  jQuery('#modal_ajax .modal-body').html(response);
              }
          });
      }

      function complete_wastage(id)
      {
        $.ajax({
            type : "POST",
            url  : "<?=base_url(); ?>poy/wpoy_accept/"+id,
            success: function(ele){
              location.reload();
            }
          })
      }
  </script>

  </body>
</html>
