const newsList = document.querySelector('.news_list');
const loadMoreBtn = document.querySelector('.loadMoreBtn');

const newsPerPage = 2;
let currentIndex = 0;
let allNews = [];

const renderBlock = (block, container) => {
	switch (block.type) {
		case 'paragraph':
			const p = document.createElement('p');
			p.classList.add('news_content');
			p.textContent = block.text;
			container.appendChild(p);
			break;

		case 'list':
			const listTitle = document.createElement('h4');
			listTitle.textContent = block.title;
			container.appendChild(listTitle);

			block.items.forEach(group => {
				const groupTitle = document.createElement('h5');
				groupTitle.textContent = `${group.title}:`;
				container.appendChild(groupTitle);

				const ul = document.createElement('ul');
				group.changes.forEach(change => {
					const li = document.createElement('li');
					li.className = change.changeType;
					li.textContent = change.text;
					ul.appendChild(li);
				});
				container.appendChild(ul);
			});
			break;

		case 'image':
			const img = document.createElement('img');
			img.src = `/templates/mytemplate/images/${block.src}`;
			img.alt = block.alt || '';
			img.className = 'clickable_image';
			img.style.width = block.width ? `${block.width}px` : '100%';

			if (block.justifySelf) {
				img.style.justifySelf = block.justifySelf;
			}

			container.appendChild(img);
			break;

		default:
			console.warn('Nieznany typ bloku:', block.type);
	}
};

const renderNewsItem = item => {
	const article = document.createElement('article');
	article.className = 'news_card';
	article.id = `news-${item.id}`;

	const grid = document.createElement('div');
	grid.className = 'news_grid';

	// Left column
	const left = document.createElement('div');
	left.className = 'news_left';

	const title = document.createElement('h3');
	title.textContent = item.title;
	left.appendChild(title);

	const date = document.createElement('small');
	date.className = 'news_date';
	date.textContent = new Date(item.date).toLocaleDateString();
	left.appendChild(date);

	item.blocks.forEach(block => {
		if (block.type === 'image') {
			return;
		}
		renderBlock(block, left);
	});

	// Right column
	const right = document.createElement('div');
	right.className = 'news_right';
	const rightImg = item.blocks.find(
		b => b.type === 'image' && b.align === 'right',
	);
	if (rightImg) renderBlock(rightImg, right);

	grid.appendChild(left);
	grid.appendChild(right);
	article.appendChild(grid);

	// Full-width image at the bottom
	const fullImage = item.blocks.find(b => b.type === 'image' && !b.align);
	if (fullImage) {
		const full = document.createElement('div');
		full.className = 'news_full_image';
		renderBlock(fullImage, full);
		article.appendChild(full);
	}

	newsList.appendChild(article);
};

const loadNextNews = () => {
	const nextBatch = allNews.slice(currentIndex, currentIndex + newsPerPage);
	nextBatch.forEach(renderNewsItem);
	currentIndex += nextBatch.length;

	if (currentIndex >= allNews.length) {
		loadMoreBtn.disabled = true;
		loadMoreBtn.textContent = 'No more to load';
	}
};

async function init() {
	try {
		const res = await fetch(
			`${import.meta.url.replace(/\/js\/.*$/, '/news.json')}`,
		);

		if (!res.ok) throw new Error(`HTTP status ${res.status}`);

		const text = await res.text();
		const data = JSON.parse(text);
		allNews = data.sort((a, b) => new Date(b.date) - new Date(a.date));
		loadNextNews();
	} catch (err) {
		console.error('Failed to initialize news:', err);
		loadMoreBtn.disabled = true;
		loadMoreBtn.textContent = 'News load error';
	}
}

document.addEventListener('click', e => {
	if (e.target.matches('.clickable_image')) {
		const src = e.target.src;
		const lightbox = document.createElement('div');
		lightbox.style.position = 'fixed';
		lightbox.style.top = '0';
		lightbox.style.left = '0';
		lightbox.style.width = '100%';
		lightbox.style.height = '100%';
		lightbox.style.backgroundColor = 'rgba(0,0,0,0.8)';
		lightbox.style.display = 'flex';
		lightbox.style.alignItems = 'center';
		lightbox.style.justifyContent = 'center';
		lightbox.style.cursor = 'zoom-out';
		lightbox.innerHTML = `<img src="${src}" style="max-width:90%; max-height:90%;">`;
		lightbox.onclick = () => document.body.removeChild(lightbox);
		document.body.appendChild(lightbox);
	}
});

loadMoreBtn.addEventListener('click', loadNextNews);
init();
