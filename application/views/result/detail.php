<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Summary Result</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<h3>Project : <?php echo $result['project']->project_name?></h3>
		<p><?php echo $result['project']->project_description?></p>
	</div>
	<div class="col-lg-8">
		<h4>Complexity Weighting Factors</h4>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Category</th>
						<th style="width: 12%">Simple</th>
						<th style="width: 12%">Avegare</th>
						<th style="width: 12%">Complex</th>
						<th style="width: 20%">Function Points</th>
					</tr>
				</thead>
				<tbody>
<?php
if (empty($result['cwf'])) {
   ?>
               <tr>
						<td colspan="5" style="text-align: center; font-style: italic;">--
							Data Not Found --</td>
					</tr>
<?php
} else {
   foreach ($result['cwf'] as $value) {
      ?>
					<tr>
						<td><?php echo $value->cwf_name;?></td>
						<td style="text-align: center;"><?php echo $value->cwf_simple;?> x <?php echo $value->cwf_weight_simple;?></td>
						<td style="text-align: center;"><?php echo $value->cwf_avarage;?> x <?php echo $value->cwf_weight_average;?></td>
						<td style="text-align: center;"><?php echo $value->cwf_complex;?> x <?php echo $value->cwf_weight_complex;?></td>
						<td style="text-align: center;">
<?php
      echo ($value->cwf_simple * $value->cwf_weight_simple) + ($value->cwf_avarage * $value->cwf_weight_average) +
          ($value->cwf_complex * $value->cwf_weight_complex);
      ?>
						</td>
					</tr>
<?php
   }
   ?>
               <tr>
						<td colspan="4" style="text-align: center; font-weight: bold;">Total
							(FP)</td>
						<td style="text-align: center; font-weight: bold;"><?php echo $result['cwf_total']?></td>
					</tr>
<?php
}
?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-8">
		<h4>Environmental Factors</h4>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Environmental Factor</th>
						<th style="width: 25%">Rating (0, 1, 2, 3, 4, 5)</th>
					</tr>
				</thead>
				<tbody>
<?php
if (empty($result['ef'])) {
   ?>
               <tr>
						<td colspan="2" style="text-align: center; font-style: italic;">--
							Data Not Found --</td>
					</tr>
<?php
} else {
   foreach ($result['ef'] as $value) {
      ?>
					<tr>
						<td><?php echo $value->ef_subject;?></td>
						<td style="text-align: center;"><?php echo $value->trans_rating;?></td>
					</tr>
<?php
   }
   ?>
               <tr>
						<td style="text-align: center; font-weight: bold;">Total (N)</td>
						<td style="text-align: center; font-weight: bold;"><?php echo $result['ef_total']?></td>
					</tr>
<?php
}
?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-6">
		<h4>Complexity Adjustment Factor (CAF)</h4>
		<p>CAF = 0.65 + (0.01 x N)</p>
		<p>CAF = 0.65 + (0.01 x <?php echo $result['ef_total']; ?>)</p>
		<p>
			CAF = <strong><?php echo 0.65 + (0.01 * $result['ef_total']); ?></strong>
		</p>

		<h4>Adjustment Function Point (AFP)</h4>
		<p>AFP = FP x CAF</p>
		<p>AFP = <?php echo $result['cwf_total']?> x <?php echo 0.65 + (0.01 * $result['ef_total']); ?></p>
		<p>
			AFP = <strong><?php echo $result['cwf_total']*(0.65 + (0.01 * $result['ef_total']))?></strong>
		</p>

		<h4>Convert to LOC (Optional)</h4>
		<p>LOC = AFP x LOC / AFP</p>
<?php
$afp = $result['cwf_total'] * (0.65 + (0.01 * $result['ef_total']));
if (! empty($afp)) {
   foreach ($result['loc'] as $value) {
      if (! empty($value->pl_lang_id)) {
         echo '<p>LOC (' . $value->lang_name . ') = (' . $afp . ' x ' . $value->lang_value . ') / ' . $afp . ' = ';
         echo '<strong>' . ($afp * $value->lang_value) / $afp . '</strong> LOC = <strong>' .
             (($afp * $value->lang_value) / $afp) / 1000 . '</strong> KLOC</p>';
      }
   }
} else {
   echo '<p>LOC = <strong>0</strong></p>';
}
?>
	</div>
</div>
<!-- /.row -->