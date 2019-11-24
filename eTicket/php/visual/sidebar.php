<div class="demo">
				
   					<div class="seat-map">
   					
						<div class="front">MENU</div>
											
					</div>
				
					<div class="booking-details">
					
						<p><i class="fas fa-plane-departure"></i>	Flight: <span> MXP-CGF</span></p>
						
						<p><i class="far fa-calendar-alt"></i>	Date: <span>November 3, 21:00</span></p>
						
						<?php if(isset($_SESSION['loggedin'])):?>
						
							<p><i class="fas fa-chair" style="color: yellow"></i> Booked Seat: </p>
							
							<ul id="selected-seats"></ul>
							
							<p id="tickets"><i class="fas fa-ticket-alt"></i>	Tickets: <span id="counter">0</span></p>
							
							<button id="buy" class="btn btn-success" onclick="buySeats()" >BUY</button>
							
						<?php endif; ?>
						
						<div id="legend"></div>
						
					</div>
				
   				</div>