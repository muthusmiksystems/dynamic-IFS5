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
		$chemicals = $this->m_masters->getmasterdetails('bud_shade_chemicals','shade_id', $shade_id);
		foreach ($chemicals as $chemical) {
			?>
			<tr>
				<td><?=$this->m_masters->getmasterIDvalue('bud_dyes_chemicals', 'dyes_chem_id', $chemical['chemical_id'], 'dyes_chem_name'); ?></td>
				<td><?=$chemical['chemical_value']; ?></td>
				<td><?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $chemical['chemical_uom'], 'uom_name'); ?></td>
				<td><a href="#" id="<?=$chemical['id']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-chemical"><i class="icon-trash "></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php

?>