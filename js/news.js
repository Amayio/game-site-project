const newsList = document.querySelector('.news_list');
const loadMoreBtn = document.querySelector('.loadMoreBtn');

const newsPerPage = 2;
let currentIndex = 0;
let allNews = [];

const renderNewsItem = item => {
	const article = document.createElement('article');
	article.className = 'news';
	article.id = `news-${item.id}`;

	const title = document.createElement('h3');
	title.textContent = item.title;
	article.appendChild(title);

	item.blocks.forEach(block => {
		if (block.type === 'paragraph') {
			const p = document.createElement('p');
			p.textContent = block.text;
			article.appendChild(p);
		}

		if (block.type === 'image') {
			const img = document.createElement('img');
			img.src = block.src;
			img.alt = block.alt || '';
			img.style.width = block.width ? `${block.width}px` : 'auto';
			article.appendChild(img);
		}

		if (block.type === 'list') {
			const listTitle = document.createElement('h4');
			listTitle.textContent = block.title;
			article.appendChild(listTitle);

			block.items.forEach(group => {
				const groupTitle = document.createElement('p');
				groupTitle.style.fontWeight = 'bold';
				groupTitle.textContent = group.title + ':';
				article.appendChild(groupTitle);

				const ul = document.createElement('ul');
				group.changes.forEach(change => {
					const li = document.createElement('li');
					li.className = change.changeType;
					li.textContent = change.text;
					ul.appendChild(li);
				});
				article.appendChild(ul);
			});
		}
	});

	newsList.appendChild(article);
};

const loadNextNews = () => {
	const nextBatch = allNews.slice(currentIndex, currentIndex + newsPerPage);
	nextBatch.forEach(renderNewsItem);
	currentIndex += nextBatch.length;

	loadMoreBtn.disabled = currentIndex >= allNews.length;
};

async function init() {
	try {
		const res = await fetch(
			`${import.meta.url.replace(/\/js\/.*$/, '/news.json')}`,
		);
		
        if (!res.ok) throw new Error(`HTTP status ${res.status}`);

		const text = await res.text();
		const data = JSON.parse(text); // stosujemy ręczny parse
		console.log('Parsed data:', Array.isArray(data), data.length);
		allNews = data.sort((a, b) => new Date(b.date) - new Date(a.date));
		loadNextNews();
	} catch (err) {
		console.error('Błąd inicjalizacji newsów:', err);
		loadMoreBtn.disabled = true;
		loadMoreBtn.textContent = 'Błąd ładowania newsów';
	}
}

loadMoreBtn.addEventListener('click', loadNextNews);
init();
