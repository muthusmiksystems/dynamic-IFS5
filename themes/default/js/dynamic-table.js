var Script = function () {

        // begin first table
        $('#table_nonshort').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false
            }]
        });

        jQuery('#table_nonshort .group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        jQuery('#table_nonshort_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#table_nonshort_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

        // begin first table
        $('#sample_1').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });

        jQuery('#sample_1 .group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        jQuery('#sample_1_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#sample_1_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

        // begin second table
        $('#sample_2').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });

        jQuery('#sample_2 .group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

        // begin: third table
        $('#sample_3').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });

        jQuery('#sample_3 .group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        jQuery('#sample_3_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#sample_3_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown


        var oTable = $('#itemlist').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6 right'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });

        jQuery('#itemlist .group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        jQuery('#itemlist_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#itemlist_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

        jQuery("#itemcode_search").live("keyup", function () {
          /* Filter on the column (the index) of this element */
          // alert('hi');
          oTable.fnFilter( this.value, 3 );
        });
           /*
         * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
         * the footer
         */
        jQuery("#itemcode_search").each( function (i) {
            asInitVals[i] = this.value;
        } );
         jQuery("#itemcode_search").focus( function () {
            if ( this.className == "search_init" )
            {
                this.className = "";
                this.value = "";
            }
        } );
         jQuery("#itemcode_search").blur( function (i) {
            if ( this.value == "" )
            {
                this.className = "search_init";
                this.value = asInitVals[jQuery("#itemcode_search").index(this)];
            }
        } );

        
}();