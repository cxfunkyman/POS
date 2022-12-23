<?php include_once 'views/templates/header.php'; ?>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-info">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total Users</p>
						<h4 class="my-1 text-info"><?php echo $data['users']['total']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'users'; ?>">Details</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
						<i class='fas fa-user'></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-danger">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total Clients</p>
						<h4 class="my-1 text-info"><?php echo $data['clients']['total']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'clients'; ?>">Details</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='fas fa-users'></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-success">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total Supplier</p>
						<h4 class="my-1 text-info"><?php echo $data['supplier']['total']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'suppliers'; ?>">Details</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
						<i class='fa-solid fa-cart-flatbed-suitcase'></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-warning">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total Products</p>
						<h4 class="my-1 text-info"><?php echo $data['products']['total']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'products'; ?>">Details</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
						<i class="fa-solid fa-cubes-stacked"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end row-->

<div class="row">
	<div class="col-12 col-lg-12">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h6 class="mb-0">Sales & Purchases</h6>
					</div>
					<div class="form-group">
						<label for="yearSP">Year</label>
						<select id="yearSP" onchange="salesAndPurchases()">
							<?php
							$dates = date('Y');
							for ($i = 2022; $i <= $dates; $i++) { ?>
								<option value="<?php echo $i; ?>" <?php echo ($dates == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>;
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #18caca"></i>Sales</span>
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #aa1818"></i>Purchases</span>
				</div>
				<div class="chart-container-1">
					<canvas id="salesAndPurchases"></canvas>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-0 row-group text-center border-top">
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0" id="totalSale"><?php echo CURRENCY ?>0.00</h5>
						<small class="mb-0">Total Sales</small>
					</div>
				</div>
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0" id="totalPurchase"><?php echo CURRENCY ?>0.00</h5>
						<small class="mb-0">Total Purchases</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-12">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h6 class="mb-0">Cash-Credits-Discounts</h6>
					</div>
					<div class="form-group">
						<label for="yearCCD">Year</label>
						<select id="yearCCD" onchange="cashCreditsDiscounts()">
							<?php
							$dates = date('Y');
							for ($i = 2022; $i <= $dates; $i++) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>;
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #d89411"></i>Cash</span>
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #161aef"></i>Credits</span>
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #b615a3"></i>Discounts</span>
				</div>
				<div class="chart-container-1">
					<canvas id="cashAndCredits"></canvas>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
				<div class="col">
					<div class="p-3 text-center">
						<h5 class="mb-0" id="saleCash"><?php echo CURRENCY ?>0.00</h5>
						<p class="mb-0">Cash</p>
					</div>
				</div>
				<div class="col">
					<div class="p-3 text-center">
						<h5 class="mb-0" id="saleCredit"><?php echo CURRENCY ?>0.00</h5>
						<p class="mb-0">Credits</p>
					</div>
				</div>
				<div class="col">
					<div class="p-3 text-center">
						<h5 class="mb-0" id="saleDiscount"><?php echo CURRENCY ?>0.00</h5>
						<p class="mb-0">Discounts</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-12">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Recent 10 Products</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table align-middle mb-0">
						<thead class="table-light">
							<tr>
								<th>Product</th>
								<th>Photo</th>
								<th>Purchase Price</th>
								<th>Sale Price</th>
								<th>Date</th>
								<th>Category</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['newProducts'] as $product) {
								if ($product['photo'] == null) {
									$photo = BASE_URL . 'assets/images/products/default.jpg';
								} else {
									$photo = BASE_URL . $product['photo'];
								}
							?>
								<tr>
									<td><?php echo $product['description']; ?></td>
									<td><img src="<?php echo $photo; ?>" class="product-img-2" alt="product img"></td>
									<td><span class="badge bg-gradient-quepal text-black shadow-sm w-100">
											<?php echo CURRENCY . $product['purchase_price']; ?></span></td>
									<td><span class="badge bg-gradient-scooter text-black shadow-sm w-100">
											<?php echo CURRENCY . $product['sale_price']; ?></span></td>
									<td><?php echo $product['dates']; ?></td>
									<td><?php echo $product['category']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!--end row-->

<div class="row row-cols-1 row-cols-lg-2">
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div>
							<h6 class="mb-0">Top 5 Products</h6>
						</div>
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="javascript:;">Action</a>
								</li>
								<li><a class="dropdown-item" href="javascript:;">Another action</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="javascript:;">Something else here</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="chart-container-2 mt-4">
						<canvas id="topProducts"></canvas>
					</div>
				</div>
				<ul class="list-group list-group-flush">

					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['topProducts'][0]['description'] ?> <span class="badge bg-success rounded-pill"><?php echo $data['topProducts'][0]['sales'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['topProducts'][1]['description'] ?> <span class="badge bg-info rounded-pill"><?php echo $data['topProducts'][1]['sales'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['topProducts'][2]['description'] ?> <span class="badge bg-primary rounded-pill"><?php echo $data['topProducts'][2]['sales'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['topProducts'][3]['description'] ?> <span class="badge bg-warning text-dark rounded-pill"><?php echo $data['topProducts'][3]['sales'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['topProducts'][4]['description'] ?> <span class="badge bg-danger text-dark rounded-pill"><?php echo $data['topProducts'][4]['sales'] ?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h6 class="mb-0">Monthly Expenses</h6>
					</div>
					<div class="form-group">
						<label for="yearEX">Year</label>
						<select id="yearEX" onchange="expenseGraph()">
							<?php
							$dates = date('Y');
							for ($i = 2022; $i <= $dates; $i++) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>;
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="d-flex align-items-center mb-4">
					<div>
						<h7 class="mb-0" id="expenseTotal">Year Total Expense <?php echo CURRENCY ?>0.00</h7>
					</div>
				</div>
				<div class="chart-container-0">
					<canvas id="expenses"></canvas>
				</div>

			</div>
		</div>
	</div>
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">5 Products With Minimum Stock</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="chart-container-2 mt-4">
					<canvas id="minStock"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
			<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['minimumStock'][0]['description'] ?> <span class="badge bg-success rounded-pill"><?php echo $data['minimumStock'][0]['quantity'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['minimumStock'][1]['description'] ?> <span class="badge bg-info rounded-pill"><?php echo $data['minimumStock'][1]['quantity'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['minimumStock'][2]['description'] ?> <span class="badge bg-primary rounded-pill"><?php echo $data['minimumStock'][2]['quantity'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['minimumStock'][3]['description'] ?> <span class="badge bg-warning text-dark rounded-pill"><?php echo $data['minimumStock'][3]['quantity'] ?></span>
					</li>
					<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
						<?php echo $data['minimumStock'][4]['description'] ?> <span class="badge bg-danger text-dark rounded-pill"><?php echo $data['minimumStock'][4]['quantity'] ?></span>
					</li>
			</ul>
		</div>
	</div>
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h6 class="mb-0">Reserves Summary</h6>
					</div>
					<div class="form-group">
						<label for="yearRS">Year</label>
						<select id="yearRS" onchange="reservesSummary()">
							<?php
							$dates = date('Y');
							for ($i = 2022; $i <= $dates; $i++) { ?>
								<option value="<?php echo $i; ?>" <?php echo ($dates == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>;
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="chart-container-2 mt-4">
					<canvas id="reserveSummary"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Completed <span class="badge bg-gradient-darklush rounded-pill" id="compRS"></span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Pending <span class="badge bg-gradient-blues rounded-pill" id="pendRS"></span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Cancelled <span class="badge bg-gradient-burning rounded-pill" id="cancRS"></span>
				</li>
			</ul>
		</div>
	</div>
</div>
<!--end row-->

<?php include_once 'views/templates/footer.php'; ?>