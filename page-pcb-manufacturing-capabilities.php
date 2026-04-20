<?php
/**
 * Template Name: PCB Manufacturing Capabilities
 */
get_header(); ?>

<main class="premium-page cap-page">
    <section class="page-hero">
        <div class="container">
            <div class="hero-content reveal">
                <span class="badge">TECHNICAL SPECS</span>
                <h1>Manufacturing <span class="gradient-text">Excellence</span></h1>
                <p class="lead">From prototypes to high-volume production, our facility is equipped to handle the most complex PCB requirements.</p>
            </div>
        </div>
    </section>

    <section class="specs-table-section reveal">
        <div class="container">
            <div class="caps-grid">
                <!-- Column 1: Material & Basics -->
                <div class="cap-card">
                    <h3>Base Materials & Layers</h3>
                    <ul class="cap-list">
                        <li><strong>Layer Count:</strong> 1 - 32 Layers</li>
                        <li><strong>Materials:</strong> FR4 (Standard, High-Tg), Aluminum, Copper Base, Rogers, Teflon, Polyimide (Flex)</li>
                        <li><strong>Board Thickness:</strong> 0.2mm - 6.0mm</li>
                        <li><strong>Max Board Size:</strong> 500mm x 1100mm</li>
                        <li><strong>Copper Weight:</strong> 0.5oz - 10oz (Heavy Copper)</li>
                    </ul>
                </div>

                <!-- Column 2: Precision & Density -->
                <div class="cap-card">
                    <h3>Design Precision</h3>
                    <ul class="cap-list">
                        <li><strong>Min. Trace/Space:</strong> 3mil / 3mil (0.075mm)</li>
                        <li><strong>Min. Drill Size:</strong> 0.15mm (Mechanical), 0.1mm (Laser)</li>
                        <li><strong>Aspect Ratio:</strong> 12:1</li>
                        <li><strong>Solder Mask Clearance:</strong> 2mil</li>
                        <li><strong>Impedance Control:</strong> ±5% or ±10%</li>
                    </ul>
                </div>

                <!-- Column 3: Finishing & Special -->
                <div class="cap-card">
                    <h3>Finishing & Others</h3>
                    <ul class="cap-list">
                        <li><strong>Surface Finish:</strong> HASL, Lead-Free HASL, ENIG, ENEPIG, OSP, Immersion Silver/Tin, Hard Gold</li>
                        <li><strong>Solder Mask Colors:</strong> Green, Blue, Red, Black, White, Purple, Yellow, Matte Green/Black</li>
                        <li><strong>Specialties:</strong> Blind/Buried Vias, Via-in-Pad, Edge Plating, Countersinks, Castellated Holes</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="detailed-specs reveal">
        <div class="container">
            <div class="glass-table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Standard Capability</th>
                            <th>Advanced Capability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Min Trace Width / Space</td>
                            <td>4 mil / 4 mil</td>
                            <td>3 mil / 3 mil</td>
                        </tr>
                        <tr>
                            <td>Min Hole Size (Mechanical)</td>
                            <td>0.2 mm</td>
                            <td>0.15 mm</td>
                        </tr>
                        <tr>
                            <td>Min Laser Drill Size</td>
                            <td>0.1 mm</td>
                            <td>0.075 mm</td>
                        </tr>
                        <tr>
                            <td>Multilayer Stackup Tolerance</td>
                            <td>±10%</td>
                            <td>±5%</td>
                        </tr>
                        <tr>
                            <td>Peelable Mask</td>
                            <td>Available</td>
                            <td>Multi-location</td>
                        </tr>
                        <tr>
                            <td>Via Density</td>
                            <td>Standard</td>
                            <td>High-Density Interconnect (HDI)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<style>
.premium-page { background: #000; color: #fff; padding-bottom: 8rem; }
.page-hero { padding: 12rem 0 6rem; text-align: center; }
.badge { background: rgba(0, 123, 255, 0.1); color: #007bff; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 2rem; border: 1px solid rgba(0, 123, 255, 0.2); }
.page-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.04em; }
.page-hero .lead { font-size: 1.1rem; color: var(--text-muted); max-width: 600px; margin: 0 auto; }
.gradient-text { background: linear-gradient(135deg, #007bff, #00d2ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.specs-table-section { padding: 4rem 0; }
.caps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; }
.cap-card { background: var(--surface); padding: 3rem; border-radius: 1.5rem; border: 1px solid var(--glass-border); }
.cap-card h3 { font-size: 1.3rem; margin-bottom: 2rem; color: #fff; position: relative; padding-bottom: 1rem; }
.cap-card h3::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: #007bff; border-radius: 2px; }
.cap-list { list-style: none; padding: 0; margin: 0; }
.cap-list li { margin-bottom: 1.25rem; font-size: 0.95rem; color: var(--text-muted); line-height: 1.5; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.75rem; }
.cap-list li:last-child { border-bottom: none; }
.cap-list li strong { color: #fff; font-weight: 600; display: block; margin-bottom: 0.25rem; }

.detailed-specs { padding: 4rem 0; }
.glass-table-container { background: var(--surface); border-radius: 1.5rem; border: 1px solid var(--glass-border); overflow: hidden; }
.premium-table { width: 100%; border-collapse: collapse; text-align: left; }
.premium-table th { background: rgba(255,255,255,0.03); padding: 1.5rem 2rem; font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--glass-border); }
.premium-table td { padding: 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 1rem; color: var(--text-muted); }
.premium-table tr:last-child td { border-bottom: none; }
.premium-table td:first-child { color: #fff; font-weight: 600; width: 40%; }

@media (max-width: 992px) {
    .caps-grid { grid-template-columns: 1fr; }
    .page-hero h1 { font-size: 2.5rem; }
}
</style>

<?php get_footer(); ?>
