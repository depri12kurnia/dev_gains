<!-- PAGE: COMPETITION -->
<div id="page-competition" class="page-section bg-white active">
    <div class="container" style="max-width:1000px;">
        <?php
        $competitionData = array(
            'irpc' => array(
                'title' => 'International Research Pitch Competition (IRPC)',
                'description' => 'Showcase your research innovation through compelling pitches to international judges.',
                'requirements' => array(
                    'Original research conducted within the past 5 years',
                    'Clear innovation or application potential',
                    'Oral presentation in English (8-10 minutes)',
                    'Abstract (200-300 words)',
                    'Supporting slides or video'
                ),
                'criteria' => array(
                    'Research Quality' => '30%',
                    'Innovation & Originality' => '25%',
                    'Applicability & Impact' => '20%',
                    'Presentation Quality' => '15%',
                    'Global Relevance' => '10%'
                ),
                'prizes' => array(
                    '1st Place' => 'USD 2,000 + Certificate',
                    '2nd Place' => 'USD 1,500 + Certificate',
                    '3rd Place' => 'USD 1,000 + Certificate'
                )
            ),
            'bppa' => array(
                'title' => 'Best Published Paper Award (BPPA)',
                'description' => 'Highlight your published research that demonstrates excellence and impact.',
                'requirements' => array(
                    'Published in peer-reviewed journal (within last 3 years)',
                    'DOI or journal citation required',
                    'Paper summary (500 words)',
                    'Publication metrics/impact data',
                    'Author affiliation proof'
                ),
                'criteria' => array(
                    'Publication Quality' => '35%',
                    'Research Rigor' => '25%',
                    'Academic Impact' => '20%',
                    'Relevance to GAINS' => '20%'
                ),
                'prizes' => array(
                    '1st Place' => 'USD 1,500 + Certificate',
                    '2nd Place' => 'USD 1,000 + Certificate',
                    '3rd Place' => 'USD 500 + Certificate'
                )
            ),
            'ahic' => array(
                'title' => 'Academic & Health Innovation Challenge (AHIC)',
                'description' => 'Present your health innovation solution addressing real-world healthcare challenges.',
                'requirements' => array(
                    'Innovation concept or prototype',
                    'Problem statement clearly defined',
                    'Video demonstration (max 5 minutes)',
                    'Innovation canvas/proposal document',
                    'Feasibility & sustainability plan'
                ),
                'criteria' => array(
                    'Innovation Novelty' => '30%',
                    'Problem-Solution Fit' => '25%',
                    'Feasibility & Scalability' => '20%',
                    'Impact Potential' => '15%',
                    'Presentation Quality' => '10%'
                ),
                'prizes' => array(
                    '1st Place' => 'USD 2,500 + Certificate',
                    '2nd Place' => 'USD 1,500 + Certificate',
                    '3rd Place' => 'USD 1,000 + Certificate'
                )
            ),
            'e2ipbc' => array(
                'title' => 'Evidence-to-Impact Policy Brief Competition (E2I-PBC)',
                'description' => 'Transform research evidence into actionable policy recommendations.',
                'requirements' => array(
                    'Evidence-based policy brief (2,000-3,000 words)',
                    'Clear policy recommendations',
                    'Supported by recent research/data',
                    'Implementation strategy',
                    'Target audience identification'
                ),
                'criteria' => array(
                    'Evidence Quality' => '30%',
                    'Policy Relevance' => '25%',
                    'Feasibility & Implementation' => '20%',
                    'Writing Quality' => '15%',
                    'Stakeholder Engagement' => '10%'
                ),
                'prizes' => array(
                    '1st Place' => 'USD 2,000 + Certificate',
                    '2nd Place' => 'USD 1,200 + Certificate',
                    '3rd Place' => 'USD 800 + Certificate'
                )
            )
        );

        $comp = isset($comp_type) && isset($competitionData[$comp_type]) ? $competitionData[$comp_type] : $competitionData['irpc'];
        ?>

        <h1 class="text-4xl mb-2"><?php echo $comp['title']; ?></h1>
        <p class="text-lg text-gray-600 mb-12"><?php echo $comp['description']; ?></p>

        <div class="grid lg-grid-2" style="gap:2rem; margin-bottom:3rem;">
            <div>
                <h2 class="text-2xl mb-6">Requirements</h2>
                <ul style="display:flex; flex-direction:column; gap:1rem;">
                    <?php foreach ($comp['requirements'] as $req): ?>
                        <li class="flex items-start">
                            <i data-lucide="check-circle" class="text-secondary mr-2" style="flex-shrink:0; margin-top:2px;"></i>
                            <span class="text-gray-700"><?php echo $req; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl mb-6">Evaluation Criteria</h2>
                <div class="bg-white rounded-xl border p-6" style="display:flex; flex-direction:column; gap:0.75rem;">
                    <?php foreach ($comp['criteria'] as $criterion => $weight): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium"><?php echo $criterion; ?></span>
                            <span class="text-primary font-bold"><?php echo $weight; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="bg-gradient-primary text-white rounded-2xl p-8">
            <h2 class="text-3xl mb-6">Prize Pool</h2>
            <div class="grid md-grid-3" style="gap:2rem;">
                <?php foreach ($comp['prizes'] as $place => $prize): ?>
                    <div style="text-align:center;">
                        <p style="font-size:0.875rem; opacity:0.9; margin-bottom:0.5rem;"><?php echo $place; ?></p>
                        <p class="text-2xl font-bold"><?php echo $prize; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-top:3rem; text-align:center;">
            <a href="<?php echo base_url('auth'); ?>" class="btn btn-gradient text-lg" style="text-decoration: none; display: inline-block;">
                Submit Your Entry Now
            </a>
        </div>
    </div>
</div>