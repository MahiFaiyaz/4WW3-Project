<!-- Login Form -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalTitle">Login</h5>
			</div>
			<div class="modal-body">
				<form  method="POST" id="Login" action="./database/login.php">
					<label for="loginEmail" class="form-label mt-3">Email Address</label>
					<input type="email" id="loginEmail" name="loginEmail" class="form-control mb-3" placeholder="name@example.com"/>
					<label for="loginPassword" class="form-label">Password</label>
					<input type="password" id="loginPassword" name="loginPassword" class="form-control mb-3" placeholder="Password"/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"  onchange="return validateTOS()" value="" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
					<button type="button" class="btn btn-light btn-outline-danger" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-light btn-outline-dark">Login</button>
				</form>
			</div>
		</div>
	</div>
</div>