<?php
class Ysindia_Career_Block_Career extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCareer()     
     { 
        if (!$this->hasData('career')) {
            $this->setData('career', Mage::registry('career'));
        }
        return $this->getData('career');
        
    }
    public function getCaliforniaJobsTitle(){
        $modelData = Mage::getModel('career/career')->getCollection();
        $state ='California';
        echo '<div class="pg-heading">
				<h2>Jobs: '.$state.'</h2>
			</div>';
        $i= 1;
        foreach($modelData as $careerdata){
                if($careerdata->getJobState()==1){

                  echo '<div class="job-title-list"><ul><li><a href="#job'.$i.'"><span>'.$careerdata->getJobTitle().'</span>'.$careerdata->getLocation().'</a></li></ul></div>';
                     }
                $i++;
                }
        echo $this->getCaliforniaJobsDetails();
        }
    public function getCaliforniaJobsDetails(){
        $modelData = Mage::getModel('career/career')->getCollection();
        $state ='';
        $i= 1;
        foreach($modelData as $careerdata){
            if($careerdata->getJobState()==1){

                if($careerdata->getJobTitle()){
                    echo  '<div id="job'.$i.'" class="job-description">
                                <h2 class="job-title">'.$careerdata->getJobTitle().'
                                </h2>
                                    <div class="job-attributes">
                                        <ul>
                                            <li><span>Available Positions:</span>2</li>
                                            <li><span>Location:</span>'.$careerdata->getLocation().'</li>
                                            <li><span>Reporting To:</span>'.$careerdata->getReportingTo().'</li>
                                            <li><span>Working With:</span>'.$careerdata->getWorkingWith().'</li>
                                            <li><span>Type:</span>'.$careerdata->getType().'</li>
                                            <li><span>Compensation:</span>'.$careerdata->getCompensation().'</li>
                                        </ul>
                                    </div>'.$careerdata->getIntroduction().'<h6>RESPONSIBILITIES</h6>'.$careerdata->getResponsibilities().'<h6>Desired Skills, Qualifications And Experience</h6>
                '.$careerdata->getDesiredSkill().'
                <h6>How To Apply:</h6>
                '.$careerdata->getHowToApply().'
                <h6>About YOGASMOGA</h6>
                    <p>YOGASMOGA is a designer, manufacturer and retailer of Yoga inspired athletic apparel and accessories. The company&rsquo;s yoga apparel is both fashionable and sporty in nature and has roots in the rapidly growing Yoga movement. YOGASMOGA develops fiber-to-consumer technological solutions to deliver proprietary high performance fabric and athletic gear. While the company works with the most technically advanced fabric and manufacturing technologies. it also pursues a relentless focus on the traditions of Yoga. YOGASMOGA also helps the development of the NAMASKAR foundation, a bracelet driven charity focused on health, education and micro lending in the compan&rsquo;s supply chain countries.</p>
                </div>';
                }
                else{
                    echo '<p>There are no open positions available at this time, please check back later for new openings.</p>';
                }

        }

            $i++;
        }
    }
    /* for Connecticut. */
    public function getConnecticutJobsTitle(){
        $modelData = Mage::getModel('career/career')->getCollection();
        $state ='Connecticut';
        echo '<div class="pg-heading">
				<h2>Jobs: '.$state.'</h2>
			</div>';
        $i= 1;
        foreach($modelData as $careerdata){
            if($careerdata->getJobState()==2){

                echo '<div class="job-title-list"><ul><li><a href="#job'.$i.'"><span>'.$careerdata->getJobTitle().'</span>'.$careerdata->getLocation().'</a></li></ul></div>';
            }
            $i++;
        }
        echo $this->getConnecticutDetails();
    }
    public function getConnecticutDetails(){
        $modelData = Mage::getModel('career/career')->getCollection();
        $j= 1;
        foreach($modelData as $connecticutdata){
            if($connecticutdata->getJobState()==2){

                if($connecticutdata->getJobTitle()){
                    echo  '<div id="job'.$j.'" class="job-description">
                                <h2 class="job-title">'.$connecticutdata->getJobTitle().'
                                </h2>
                                    <div class="job-attributes">
                                        <ul>
                                            <li><span>Available Positions:</span>2</li>
                                            <li><span>Location:</span>'.$connecticutdata->getLocation().'</li>
                                            <li><span>Reporting To:</span>'.$connecticutdata->getReportingTo().'</li>
                                            <li><span>Working With:</span>'.$connecticutdata->getWorkingWith().'</li>
                                            <li><span>Type:</span>'.$connecticutdata->getType().'</li>
                                            <li><span>Compensation:</span>'.$connecticutdata->getCompensation().'</li>
                                        </ul>
                                    </div>'.$connecticutdata->getIntroduction().'<h6>RESPONSIBILITIES</h6>'.$connecticutdata->getResponsibilities().'<h6>Desired Skills, Qualifications And Experience</h6>
                '.$connecticutdata->getDesiredSkill().'
                <h6>How To Apply:</h6>
                '.$connecticutdata->getHowToApply().'
                <h6>About YOGASMOGA</h6>
                    <p>YOGASMOGA is a designer, manufacturer and retailer of Yoga inspired athletic apparel and accessories. The company&rsquo;s yoga apparel is both fashionable and sporty in nature and has roots in the rapidly growing Yoga movement. YOGASMOGA develops fiber-to-consumer technological solutions to deliver proprietary high performance fabric and athletic gear. While the company works with the most technically advanced fabric and manufacturing technologies. it also pursues a relentless focus on the traditions of Yoga. YOGASMOGA also helps the development of the NAMASKAR foundation, a bracelet driven charity focused on health, education and micro lending in the compan&rsquo;s supply chain countries.</p>
                </div>';
                }
                else{
                    echo '<p>There are no open positions available at this time, please check back later for new openings.</p>';
                }

            }

            $j++;
        }
    }
    // for Massachusetts.

    public function getMassachusettsJobsTitle()
    {
        $modelData = Mage::getModel('career/career')->getCollection();
        $state = 'Massachusetts';
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $query = 'SELECT * FROM ' . $readConnection->getTableName('career') . ' where job_state="' . $state . '"';
        $results = $readConnection->fetchAll($query);
        $resutldata = count($results);

        echo '<div class="pg-heading">
				<h2>Jobs: ' . $state . '</h2>
			</div>';
        if ($resutldata > 0 && $resutldata['status']==1) {

                    $i = 1;
                    foreach ($modelData as $careerdata) {
                        if ($careerdata->getJobState() == 3) {

                            echo '<div class="job-title-list"><ul><li><a href="#job' . $i . '"><span>' . $careerdata->getJobTitle() . '</span>' . $careerdata->getLocation() . '</a></li></ul></div>';
                        }
                        $i++;
                    }

        echo $this->getMassachusettsJobsDetails();
    }
        else{
            echo '<p>There are no open positions available at this time, please check back later for new openings.</p>';

        }

    }
    public function getMassachusettsJobsDetails(){
        $modelData = Mage::getModel('career/career')->getCollection();
        $i= 1;
        foreach($modelData as $careerdata){
            if($careerdata->getJobState()==3){
        }

            $i++;
        }
    }

}