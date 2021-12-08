<!-- Login Form that required email address, password, and button to remember user -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalTitle">Login</h5>
			</div>
			<div class="modal-body">
				<!-- submits to database/login -->
				<form  method="POST" id="Login" action="./database/login.php">
					<label for="loginEmail" class="form-label mt-3">Email Address</label>
					<!-- If cookies were set, then email is automatically displayed based on the one saved in the cookie -->
					<input type="email" id="loginEmail" name="loginEmail" class="form-control mb-3" placeholder="name@example.com" value="
					<?php if((isset($_COOKIE['Email'])) && !empty($_COOKIE['Email'])){
						echo $_COOKIE['Email'];
					} ?>"/>
					<label for="loginPassword" class="form-label">Password</label>
					<input type="password" id="loginPassword" name="loginPassword" class="form-control mb-3" placeholder="Password"/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
					<!-- Hidden input that submits the current URL, so user can be redirected after logging in -->
					<input type="hidden" name="requestURI" value="<?=$_SERVER['REQUEST_URI']?>"/>
					<button type="button" class="btn btn-light btn-outline-danger" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-light btn-outline-dark">Login</button>
				</form>
			</div>
		</div>
	</div>
</div>