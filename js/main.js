document.addEventListener('DOMContentLoaded', () => {

    const html = document.documentElement;
    const body = document.body;

    // --- LÓGICA DE CONTROLE DE FONTE ---
    const btnIncreaseFont = document.getElementById('increase-font');
    const btnDecreaseFont = document.getElementById('decrease-font');
    const MIN_FONT_SIZE = 12;
    const MAX_FONT_SIZE = 20;

    const applyFontSize = (size) => {
        html.style.fontSize = size + 'px';
        localStorage.setItem('fontSize', size);
    };

    btnIncreaseFont.addEventListener('click', () => {
        let currentSize = parseFloat(getComputedStyle(html).fontSize);
        if (currentSize < MAX_FONT_SIZE) {
            applyFontSize(currentSize + 1);
        }
    });

    btnDecreaseFont.addEventListener('click', () => {
        let currentSize = parseFloat(getComputedStyle(html).fontSize);
        if (currentSize > MIN_FONT_SIZE) {
            applyFontSize(currentSize - 1);
        }
    });


    // --- LÓGICA DE CONTRASTE (TEMA) ---
    const btnToggleContrast = document.getElementById('toggle-contrast');

    const applyTheme = (theme) => {
        if (theme === 'dark') {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
        localStorage.setItem('theme', theme);
    };

    btnToggleContrast.addEventListener('click', () => {
        const currentTheme = localStorage.getItem('theme') || 'light';
        applyTheme(currentTheme === 'light' ? 'dark' : 'light');
    });


    // --- INICIALIZAÇÃO ---
    // Aplica as preferências salvas assim que a página carrega
    const savedFontSize = localStorage.getItem('fontSize');
    if (savedFontSize) {
        html.style.fontSize = savedFontSize + 'px'; // Aplica direto sem a função para não salvar de novo
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        applyTheme(savedTheme); // Usa a função para garantir que a classe seja aplicada
    }

});