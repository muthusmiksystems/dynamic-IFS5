<!DOCTYPE html>
<html>

<head>
    <title>Gray Yarn Soft Packing Slip</title>
    <style type="text/css">
        table {
            
            border-collapse: collapse;
        }

        table td {
            font-size: 7.5pt;
            font-family: "Arial Rounded MT", Arial, Helvetica, sans-serif;
            font-weight: bold;
            padding-left: 10px;
        }

        table tr td.ps-title {
            font-weight: bold;
            font-size: 9pt;
            text-align: center;
        }

        table tr td.ps-boxno {
            font-weight: bold;
            font-size: 13pt;
        }

        span.ps-time {
            font-size: 5pt;
            text-align: center;
        }

        table tr td.ps-barcode {
            text-align: center;
            float: none;
        }

        #bcTarget {
            margin: 0 auto;
        }

        table tr.border-top td {
            border-top: 1px solid #000;
        }

        table td.border-right {
            border-right: 1px solid #000;
            padding-right: 2px;
        }

        table .ps-footer {
            text-align: center;
        }
    </style>
    <?php
    foreach ($js as $path) {
    ?>
        <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
    <?php
    }
    ?>
</head>
<?php
if (isset($yarn_lot_id)) {
    $editpoylots = $this->m_masters->getmasterdetails('bud_yarn_lots', 'yarn_lot_id', $yarn_lot_id);
    foreach ($editpoylots as $yarn_lot) {
        $yarn_denier = $yarn_lot['yarn_denier'];
        $yarn_lot_name = $yarn_lot['yarn_lot_name'];
        $yarn_lot_no = $yarn_lot['yarn_lot_no'];
        $yarn_reorder = $yarn_lot['yarn_reorder'];
        $yarn_lot_uom = $yarn_lot['yarn_lot_uom'];
        $yarn_status = $yarn_lot['yarn_status'];
        $poy_denier_id = $yarn_lot['poy_denier_id'];

        $yarn_lot_machinespeed = $yarn_lot['yarn_lot_machinespeed'];
        $yarn_lot_dy = $yarn_lot['yarn_lot_dy'];
        $yarn_lot_draw = $yarn_lot['yarn_lot_draw'];
        $yarn_lot_sos = $yarn_lot['yarn_lot_sos'];
        $yarn_lot_takeuphardwind = $yarn_lot['yarn_lot_takeuphardwind'];
        $yarn_lot_takeupsoftwind = $yarn_lot['yarn_lot_takeupsoftwind'];
        $yarn_lot_primarytemp = $yarn_lot['yarn_lot_primarytemp'];
        $yarn_lot_secondarytemp = $yarn_lot['yarn_lot_secondarytemp'];
        $yarn_lot_cpmhardwind = $yarn_lot['yarn_lot_cpmhardwind'];
        $yarn_lot_cpmsoftwind = $yarn_lot['yarn_lot_cpmsoftwind'];
        $yarn_lot_rottopresher = $yarn_lot['yarn_lot_rottopresher'];
        $yarn_lot_remarks = $yarn_lot['yarn_lot_remarks'];
        $yarn_lot_poyinwardno = $yarn_lot['yarn_lot_poyinwardno'];
        $date = $yarn_lot['date'];
        $user_id = $yarn_lot['user_id'];
    }
} else {
    $yarn_lot_id = '';
    $yarn_denier = '';
    $yarn_lot_name = '';
    $yarn_lot_no = '';
    $yarn_reorder = '';
    $yarn_lot_uom = '';
    $yarn_status = '';
    $poy_denier_id = '';

    $yarn_lot_machinespeed = '0';
    $yarn_lot_dy = '0';
    $yarn_lot_draw = '0.000';
    $yarn_lot_sos = '0';
    $yarn_lot_takeuphardwind = '0';
    $yarn_lot_takeupsoftwind = '0';
    $yarn_lot_primarytemp = '0';
    $yarn_lot_secondarytemp = '0';
    $yarn_lot_cpmhardwind = '0';
    $yarn_lot_cpmsoftwind = '0';
    $yarn_lot_rottopresher = '0';
    $yarn_lot_remarks = '';
    $yarn_lot_poyinwardno = '';
    $date = '';
    $user_id = '';
} ?>
<?php
$v = $poy_denier_id;
$current = current(array_filter($poy_deniers, function ($e) use ($v) {
return $e->denier_id == $v;
}));
$pdenier_name = @$current->denier_name . ' / ' . $v;

$v = $yarn_denier;
$current = current(array_filter($yarn_deniers, function ($e) use ($v) {
return $e['denier_id'] == $v;
}));
$ydenier_name = @$current['denier_name'] . ' / ' . $v;
?>
<body onload="window.print();">
    <table style="width:100%;margin:0 auto;">
        <tr>
            <td width="15%"></td>
            <td width="35%"></td>
            <td width="15%"></td>
            <td width="35%"></td>
        </tr>
        <tr>
            <td colspan="3" class="ps-title" style="text-align: left;">Chandren Lot No : <?= $yarn_lot_no; ?> </td>
            <td class="ps-title" style="text-align: right;">Lot No: CL-<?=$yarn_lot_id; ?> &nbsp;&nbsp; </td>
        </tr>
        <tr>
            <td>POY Dn.</td>
            <td>: <span style="font-size: 8.5pt;"><?= $pdenier_name; ?></span></td>
            <td>F. Yarn Dn.</td>
            <td>: <span style="font-size: 8.5pt;"><?= $ydenier_name; ?></span></td>
        </tr>

        <tr>
            <td>Poy In.</td>
            <td>: <?= $yarn_lot_poyinwardno; ?></td>
            <td>Speed</td>
            <td>: <?= $yarn_lot_machinespeed; ?></td>
        </tr>

        <tr>
            <td>DY</td>
            <td>: <?= $yarn_lot_dy; ?></td>
            <td>Draw</td>
            <td>: <?= $yarn_lot_draw; ?></td>
            
        </tr>

        <tr>
            <td>SOS</td>
            <td>: <?= $yarn_lot_sos; ?></td>
            <td>Take Up H/W</td>
            <td>: <?= $yarn_lot_takeuphardwind; ?></td>
        </tr>

        <tr>
            <td>Primary</td>
            <td>: <?= $yarn_lot_primarytemp; ?></td>
            <td>Take Up S/W</td>
            <td>: <?= $yarn_lot_takeupsoftwind; ?></td>
        </tr>

        <tr>
            <td>Secondary</td>
            <td>: <?= $yarn_lot_secondarytemp; ?></td>
            <td>CPM H/W</td>
            <td>: <?= $yarn_lot_cpmhardwind; ?></td>
        </tr>

        <tr>
            <td>R. Presser</td>
            <td>: <?= $yarn_lot_rottopresher; ?></td>
            <td>CPM S/W</td>
            <td>: <?= $yarn_lot_cpmsoftwind; ?></td>  
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>User</td>
            <td>: <?= $this->m_users->getuserdetails($user_id)[0]['user_login']; ?> / <?= date("d-m-Y", strtotime($date)); ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Remarks</td>
            <td colspan="3">: <?= $yarn_lot_remarks; ?></td>
        </tr>
    </table>
</body>

</html>