<?php
class Ysindia_Career_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();
		$this->renderLayout();
    }
	public function getstatejobsAction(){


		$state = Mage::app()->getRequest()->getParam('state');
		//$state = 1;
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query = 'SELECT * FROM ' . $readConnection->getTableName('career') . ' where job_state="' . $state . '" and status="1"';
		$results = $readConnection->fetchAll($query);
		$resutldata = count($results);
		$stateText = '';
		if($state=='1'){
			$stateText = "california";
		}
		elseif($state=='2'){
			$stateText = "Connecticut";

		}
		elseif($state=='3'){
			$stateText = "Massachusetts";

		}
		elseif($state=='4'){
			$stateText = "New Jersey";

		}
		elseif($state=='5'){
			$stateText = "New York";

		}
		else{

		}


		echo '<div class="pg-heading">
				<h2>Careers: '.$stateText.'</h2>
			</div>';

		if($resutldata > 0){
			$j= 1;
			echo '<div class="job-title-list"><ul>';
			foreach($results as $careerdata){


					echo '<li><a href="#job' . $j . '"><span>' . $careerdata['job_title'] . '</span>' .
						$careerdata['location']
						. '</a></li>';


				$j++;
			}
		echo '</ul></div>';


			$i=1;
			foreach($results as $careerdata){

					echo '<div id="job' . $i . '" class="job-description">
                                <h2 class="job-title">' . $careerdata['job_title'] . '
                                </h2>
                                    <div class="job-attributes">
                                        <ul>
                                            <li><span>Available Positions:</span>' . $careerdata['available_position'] . '</li>
                                            <li><span>Location:</span>' . $careerdata['location'] . '</li>
                                            <li><span>Reporting To:</span>' . $careerdata['reporting_to'] . '</li>
                                            <li><span>Working With:</span>' . $careerdata['working_with'] . '</li>
                                            <li><span>Type:</span>' . $careerdata['type'] . '</li>
                                            <li><span>Compensation:</span>' . $careerdata['compensation'] . '</li>
                                            <li><span>Date Posted:</span>' . $careerdata['job_posted'] . '</li>
                                        </ul>
                                    </div>' . $careerdata['introduction'] . '<h6>RESPONSIBILITIES</h6>' . $careerdata['responsibilities'] . '<h6>Desired Skills, Qualifications And Experience</h6>
                ' . $careerdata['desired_skill'] . '
                <h6>How To Apply</h6>
                ' . $careerdata['how_to_apply'] . '
                <h6>About YOGASMOGA</h6>
                    <p>' . $careerdata['about_ys'] . '</p>
                </div>';

			$i++;
			}
		}
		else{

			echo "<p class='no-jobs-msg'>There are no open positions available at this time, please check back later for new openings.</p>";
		}

	}

	public function getcaliforniajobsAction(){

		$state = Mage::app()->getRequest()->getParam('state');
		//$state = 1;
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query = 'SELECT * FROM ' . $readConnection->getTableName('career') . ' where job_state="' . $state . '" and status="1"';
		$results = $readConnection->fetchAll($query);
		$resutldata = count($results);
		$stateText = '';
		if($state=='1'){
			$stateText = "california";
		}
		echo '<div class="pg-heading">
				<h2>Careers: '.$stateText.'</h2>
			</div>';

		if($resutldata > 0){
			$j= 1;
			echo '<div class="job-title-list"><ul>';
			foreach($results as $careerdata){


					echo '<li><a href="#job' . $j . '"><span>' . $careerdata['job_title'] . '</span>' .
						$careerdata['location']
						. '</a></li>';
					$j++;


			}
			echo '</ul></div>';


			$i=1;
			foreach($results as $careerdata){


					echo '<div id="job' . $i . '" class="job-description">
                                <h2 class="job-title">' . $careerdata['job_title'] . '
                                </h2>
                                    <div class="job-attributes">
                                        <ul>
                                            <li><span>Available Positions:</span>' . $careerdata['available_position'] . '</li>
                                            <li><span>Location:</span>' . $careerdata['location'] . '</li>
                                            <li><span>Reporting To:</span>' . $careerdata['reporting_to'] . '</li>
                                            <li><span>Working With:</span>' . $careerdata['working_with'] . '</li>
                                            <li><span>Type:</span>' . $careerdata['type'] . '</li>
                                            <li><span>Compensation:</span>' . $careerdata['compensation'] . '</li>
                                            <li><span>Date Posted:</span>' . $careerdata['job_posted'] . '</li>
                                        </ul>
                                    </div>' . $careerdata['introduction'] . '<h6>RESPONSIBILITIES</h6>' . $careerdata['responsibilities'] . '<h6>Desired Skills, Qualifications And Experience</h6>
                ' . $careerdata['desired_skill'] . '
                <h6>How To Apply</h6>
                ' . $careerdata['how_to_apply'] . '
                <h6>About YOGASMOGA</h6>
                    <p>' . $careerdata['about_ys'] . '</p>
                </div>';



				$i++;
			}
		}
		else{

			echo "<p class='no-jobs-msg'>There are no open positions available at this time, please check back later for new openings.</p>";
		}

	}

	//for mobile.
	public function mobilestatejobsAction(){

		$state = Mage::app()->getRequest()->getParam('state');
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query = 'SELECT * FROM ' . $readConnection->getTableName('career') . ' where job_state="' . $state . '" and status="1"';
		$results = $readConnection->fetchAll($query);
		$resutldata = count($results);
		$stateText = '';
		if($state=='1'){
			$stateText = "California";
		}
			elseif($state=='2'){
				$stateText = "Connecticut";

			}
			elseif($state=='3'){
				$stateText = "Massachusetts";

			}
			elseif($state=='4'){
				$stateText = "New Jersey";

			}
			elseif($state=='5'){
				$stateText = "New York";

			}
		else{

		}
		echo '<p class="job-state-title">'.$stateText.'</p>';

		if($resutldata > 0){
			echo '<ul>';
			foreach($results as $jobsdata) {
			echo '<li>
				<span class="toggle">
					<svg height="44px" width="44px">
						<line y2="109.657" x2="288.374" y1="109.657" x1="272.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
						<line y2="21.39" x2="30.374" y1="21.39" x1="14.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
						<line y2="29.39" x2="22.374" y1="13.39" x1="22.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
					</svg>
				</span>

				<p>' .$jobsdata['job_title'].'</p>
				<div class="answer_content">
					<div class="job-attributes">
						<ul>
							<li><span>Available Positions:</span>' .$jobsdata['available_position'].'</li>
							<li><span>Location:</span>' .$jobsdata['location'].'</li>
							<li><span>Reporting To:</span>' .$jobsdata['reporting_to'].'</li>
							<li><span>Working With:</span>' .$jobsdata['working_with'].'</li>
							<li><span>Type:</span>' .$jobsdata['type'].'</li>
							<li><span>Compensation:</span>' .$jobsdata['compensation'].'</li>
							<li><span>Date Posted:</span>' . $jobsdata['job_posted'] . '</li>
						</ul>
					</div>
					<div>' .$jobsdata['introduction'].'</div>
					<h6>Responsibilities</h6>' .$jobsdata['responsibilities'].'
					<h6>Desired Skills, Qualifications And Experience</h6>'.$jobsdata['desired_skill'].'
					<h6>How To Apply</h6>' .$jobsdata['how_to_apply'].'
					<h6>About YOGASMOGA</h6>
					<p>' . $jobsdata['about_ys'] . '</p>
				</div>
        	</li>';
				}

			echo '</ul>';
		}
		else{

			echo "<p class='no-jobs-msg'>There are no open positions available at this time, please check back later for new openings.</p>";
		}




	}

	//for mobile no triger.
	public function mobiledefaultstatejobsAction(){

		$state = Mage::app()->getRequest()->getParam('state');
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query = 'SELECT * FROM ' . $readConnection->getTableName('career') . ' where job_state="' . $state . '" and status="1"';
		$results = $readConnection->fetchAll($query);
		$resutldata = count($results);
		$stateText = '';
		if($state=='1'){
			$stateText = "California";
		}

		echo '<p class="job-state-title">'.$stateText.'</p>';

		if($resutldata > 0){
			echo '<ul>';
			foreach($results as $jobsdata) {
				echo '<li>
				<span class="toggle">
					<svg height="44px" width="44px">
						<line y2="109.657" x2="288.374" y1="109.657" x1="272.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
						<line y2="21.39" x2="30.374" y1="21.39" x1="14.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
						<line y2="29.39" x2="22.374" y1="13.39" x1="22.374" stroke-miterlimit="10" stroke="#666666"
							  fill="none"/>
					</svg>
				</span>

				<p>' .$jobsdata['job_title'].'</p>
				<div class="answer_content">
					<div class="job-attributes">
						<ul>
							<li><span>Available Positions:</span>' .$jobsdata['available_position'].'</li>
							<li><span>Location:</span>' .$jobsdata['location'].'</li>
							<li><span>Reporting To:</span>' .$jobsdata['reporting_to'].'</li>
							<li><span>Working With:</span>' .$jobsdata['working_with'].'</li>
							<li><span>Type:</span>' .$jobsdata['type'].'</li>
							<li><span>Compensation:</span>' .$jobsdata['compensation'].'</li>
							<li><span>Date Posted:</span>' . $jobsdata['job_posted'] . '</li>
						</ul>
					</div>
					<div>' .$jobsdata['introduction'].'</div>
					<h6>Responsibilities</h6>' .$jobsdata['responsibilities'].'
					<h6>Desired Skills, Qualifications And Experience</h6>'.$jobsdata['desired_skill'].'
					<h6>How To Apply</h6>' .$jobsdata['how_to_apply'].'
					<h6>About YOGASMOGA</h6>
					<p>' . $jobsdata['about_ys'] . '</p>
				</div>
        	</li>';
			}

			echo '</ul>';
		}
		else{

			echo "<p class='no-jobs-msg'>There are no open positions available at this time, please check back later for new openings.</p>";
		}




	}

}