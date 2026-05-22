<div id="page-competition" class="page-section bg-white active">
    <div class="container" style="max-width:1000px;">
        <?php
        $competitionData = array(
            'comp-irpc' => array(
                'title' => "International Research Pitch Competition (IRPC)",
                'icon' => "lightbulb",
                'format' => "A concise presentation of a research proposal for an ongoing or planned study.",
                'requirements' => ["Submission of an extended abstract (maximum 1,500 words).", "Live pitch presentation lasting strictly 5–7 minutes.", "Must clearly highlight the research problem, methodology, and expected impact on healthcare."],
                'appeal' => ["Favored by early-career and mid-career researchers.", "Reflects the format of international grant pitching schemes.", "Fast-paced, competitive, and interactive."],
                'color' => "var(--primary)",
                'lightColor' => "var(--primary-light)",
                'details' => "The IRPC provides a dynamic platform for researchers to pitch their innovative ideas clearly and persuasively. It is designed to evaluate not only the scientific merit of the proposed or ongoing research but also the researcher's ability to communicate complex concepts effectively to a broader audience."
            ),

        );

        // Logika penentuan kategori yang aktif
        $active_type = (isset($_GET['type']) && isset($competitionData[$_GET['type']])) ? $_GET['type'] : 'comp-irpc';
        $comp = $competitionData[$active_type];
        ?>

        <div class="flex flex-col items-center text-center mb-12 animate-fadeIn">
            <div style="background-color: <?php echo $comp['lightColor']; ?>; color: <?php echo $comp['color']; ?>; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem; display: inline-block;">
                <i data-lucide="<?php echo $comp['icon']; ?>" style="width: 3rem; height: 3rem;"></i>
            </div>
            <h1 class="text-4xl font-extrabold mb-6"><?php echo $comp['title']; ?></h1>
        </div>

        <div class="grid lg-grid-12">
            <div class="lg-col-8">
                <div class="mb-8">
                    <h3 class="text-2xl border mb-4" style="border-width:0 0 1px 0; padding-bottom:0.5rem;">Overview</h3>
                    <p class="text-gray-700 text-lg"><?php echo $comp['details']; ?></p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border shadow-sm">
                    <h3 class="text-2xl mb-6">Technical Details</h3>
                    <div style="display:flex; flex-direction:column; gap:1.5rem;">
                        <div>
                            <span class="flex items-center text-sm font-bold mb-2" style="text-transform:uppercase; color: <?php echo $comp['color']; ?>;">
                                <i data-lucide="file-text" style="width:1rem; margin-right:0.5rem;"></i> Format
                            </span>
                            <div class="bg-white p-4 rounded-lg border text-gray-800 font-bold" style="white-space:pre-line;">
                                <?php echo $comp['format']; ?>
                            </div>
                        </div>

                        <div>
                            <span class="flex items-center text-sm font-bold mb-2" style="text-transform:uppercase; color: <?php echo $comp['color']; ?>;">
                                <i data-lucide="check-circle" style="width:1rem; margin-right:0.5rem;"></i> Submission Requirements
                            </span>
                            <ul class="bg-white p-4 rounded-lg border text-gray-700" style="list-style-type:disc; padding-left:2rem;">
                                <?php foreach ($comp['requirements'] as $req): ?>
                                    <li><?php echo $req; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div>
                            <span class="flex items-center text-sm font-bold mb-2" style="text-transform:uppercase; color: <?php echo $comp['color']; ?>;">
                                <i data-lucide="award" style="width:1rem; margin-right:0.5rem;"></i> Key Appeal
                            </span>
                            <ul class="bg-white p-4 rounded-lg border text-gray-700" style="list-style-type:disc; padding-left:2rem;">
                                <?php foreach ($comp['appeal'] as $app): ?>
                                    <li><?php echo $app; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg-col-4">
                <div class="bg-gray-900 p-8 rounded-2xl text-white text-center shadow-lg" style="position:sticky; top:7rem;">
                    <i data-lucide="file-text" class="mb-4" style="width:3rem; height:3rem; margin:0 auto 1rem; color: var(--secondary);"></i>
                    <h3 class="text-xl mb-2">Participant Guidelines</h3>
                    <p class="text-gray-400 text-sm mb-6">Download the comprehensive rulebook covering all categories, general evaluation criteria, and formatting rules.</p>
                    <a href="<?php echo base_url('public/uploads/open/Guidelines_GAINS_2026_v3.pdf'); ?>" target="_blank" rel="noopener noreferrer">
                        <button class="btn btn-gradient w-full">
                            <i data-lucide="download" style="margin-right:0.5rem; width:1.25rem;"></i> Download Guideline
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>