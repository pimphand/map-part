<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PBB Module Functions</title>
</head>

<body>
    <h1>Test PBB Module Functions</h1>
    <div id="results"
        style="font-family: monospace; white-space: pre-wrap; background: #f0f0f0; padding: 20px; margin: 20px;"></div>

    <script>
        function log(message) {
            const results = document.getElementById('results');
            results.textContent += new Date().toLocaleTimeString() + ': ' + message + '\n';
            console.log(message);
        }

        log('Starting PBB Module test...');

        // Load PBB script
        const script = document.createElement('script');
        script.src = '/command/js/pbb.js';
        script.onload = () => {
            log('PBB script loaded successfully');

            // Wait for module to initialize
            setTimeout(() => {
                log('Checking PBBModule availability...');
                log('PBBModule exists: ' + !!window.PBBModule);

                if (window.PBBModule) {
                    const functions = Object.keys(window.PBBModule);
                    log('Available functions: ' + functions.join(', '));

                    // Test each function
                    functions.forEach(funcName => {
                        const func = window.PBBModule[funcName];
                        const isFunction = typeof func === 'function';
                        log(`${funcName}: ${isFunction ? '✓ function' : '✗ not a function'}`);
                    });

                    // Test specific functions
                    if (typeof window.PBBModule.initializePBB === 'function') {
                        log('✓ PBBModule.initializePBB is available');
                    } else {
                        log('✗ PBBModule.initializePBB is NOT available');
                    }

                    if (typeof window.PBBModule.loadPBBData === 'function') {
                        log('✓ PBBModule.loadPBBData is available');
                    } else {
                        log('✗ PBBModule.loadPBBData is NOT available');
                    }

                } else {
                    log('✗ PBBModule is not available');
                }

                log('Test completed');
            }, 100);
        };

        script.onerror = () => {
            log('✗ Failed to load PBB script');
        };

        document.head.appendChild(script);
    </script>
</body>

</html>
