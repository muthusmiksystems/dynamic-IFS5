<table class="table table-striped border-top">
	<thead>
		<tr>
			<th>Chemial</th>
			<th>Value</th>
			<th>Uom</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$dyeses = $this->m_masters->getmasterdetails('bud_shade_dyes','shade_id', $shade_id);
		foreach ($dyeses as $dyes) {
			?>
			<tr>
				<td><?=$this->m_masters->getmasterIDvalue('bud_dyes_chemicals', 'dyes_chem_id', $dyes['dyes_id'], 'dyes_chem_name'); ?></td>
				<td><?=$dyes['dyes_value']; ?></td>
				<td><?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $dyes['dyes_uom'], 'uom_name'); ?></td>
				<td><a href="#" id="<?=$dyes['id']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-dyes"><i class="icon-trash "></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php

?>