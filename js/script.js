const goToNewsBtn = document.querySelector('.goto-news-btn');
const header = document.querySelector('header');

const handleHeader = () => {
	window.addEventListener('scroll', () => {
		if (window.scrollY > 50) {
			header.classList.add('shrink');
		} else {
			header.classList.remove('shrink');
		}
	});
};

const scrollToNews = () => {
	window.scrollTo({
		top: 800,
	});
};

document.addEventListener('DOMContentLoaded', handleHeader);

goToNewsBtn.addEventListener('click', scrollToNews);
