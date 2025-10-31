const copyButtons = document.querySelectorAll('[data-copy]');
copyButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        navigator.clipboard.writeText(btn.dataset.copy || '').then(() => {
            btn.textContent = 'Copied!';
            setTimeout(() => (btn.textContent = 'Copy Link'), 2000);
        });
    });
});

const exportButtons = document.querySelectorAll('[data-export]');
exportButtons.forEach(btn => {
    btn.addEventListener('click', async () => {
        const format = btn.dataset.export;
        const story = document.querySelector('#story pre');
        if (!story) return;
        const body = story.textContent;
        const title = document.querySelector('section.card h1')?.textContent || 'MadMix Story';
        const formData = new FormData();
        formData.append('format', format || 'png');
        formData.append('title', title);
        formData.append('body', body || '');
        const response = await fetch('/api/export', { method: 'POST', body: formData });
        const blob = await response.blob();
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `madmix-story.${format}`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    });
});

const randomButtons = document.querySelectorAll('[data-random]');
randomButtons.forEach(btn => {
    btn.addEventListener('click', async () => {
        const input = btn.previousElementSibling;
        if (!(input instanceof HTMLInputElement)) return;
        const pos = btn.dataset.pos || '';
        const formData = new FormData();
        formData.append('pos', pos);
        const response = await fetch('/api/remix', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.word) {
            input.value = data.word;
            input.dispatchEvent(new Event('input'));
        }
    });
});

const storyEl = document.querySelector('#story pre');
if (storyEl) {
    const text = storyEl.textContent || '';
    storyEl.textContent = '';
    let i = 0;
    const timer = setInterval(() => {
        storyEl.textContent += text[i] || '';
        i++;
        if (i >= text.length) clearInterval(timer);
    }, 15);
}

const lobby = document.querySelector('#party-lobby');
if (lobby) {
    const code = lobby.dataset.code;
    const list = document.querySelector('#submission-list');
    const poll = async () => {
        if (!code) return;
        const response = await fetch(`/api/party/state?code=${encodeURIComponent(code)}`);
        const data = await response.json();
        if (!Array.isArray(data.submissions) || !list) return;
        list.innerHTML = '';
        data.submissions.forEach(item => {
            const li = document.createElement('li');
            li.innerHTML = `<strong>${item.placeholder_key}</strong> by ${item.user_nick} — ${item.value}`;
            list.appendChild(li);
        });
        setTimeout(poll, 3000);
    };
    poll();
}
