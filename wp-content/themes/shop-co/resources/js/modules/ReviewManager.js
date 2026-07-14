import { assertHtmlElement, fetchHtml } from "../helpers";

export class ReviewManager {
  initialized = false;

  constructor() {
    this.rootElement = document.getElementById('comments');
    this.commentListElement = document.getElementById('comment-list');
    this.loadMoreCommentsButton = document.getElementById('load-more-comments');
    this.loaderElement = document.getElementById('comments-loading');
    this.sortingElement = document.getElementById('comments-sort');

    this.validate();

    this.options = JSON.parse(this.rootElement.dataset.options);
  }

  validate() {
    assertHtmlElement(this.rootElement, '#comments');
    assertHtmlElement(this.commentListElement, '#comment-list');
    assertHtmlElement(this.loadMoreCommentsButton, '#load-more-comments');
    assertHtmlElement(this.loaderElement, '#comments-loading');
    assertHtmlElement(this.sortingElement, '#comments-sort');
  }

  updateOptions(cb) {
    this.options = cb(this.options);
    this.rootElement.dataset.options = JSON.stringify(this.options);
  }

  getTotalCount() {
    return this.options.totalCount;
  }

  getTotalPages() {
    return this.options.totalPages;
  }

  getPerPage() {
    return this.options.perPage;
  }

  getCurrentPage() {
    return this.options.currentPage;
  }

  getSorting() {
    return this.sortingElement.value;
  }

  getDefaultCommentsPage() {
    return this.options.defaultCommentsPage;
  }

  getCurrentCommentsCount() {
    return this.commentListElement.querySelectorAll('li').length;
  }

  getBaseCommentsUrl() {
    const url = new URL(window.location.href);

    url.pathname = url.pathname.replace(/\/comment-page-\d+\/?$/, '/');
    url.searchParams.delete('reviews_order');

    return url;
  }

  init() {
    if (this.initialized) {
      return;
    }

    this.initialized = true;
    
    this.loadMoreCommentsButton.hidden = !(this.getTotalCount() > this.getCurrentCommentsCount());

    this.rootElement.addEventListener('click', this.onClickHandle);
    this.rootElement.addEventListener('change', this.onChangeHandle);

    if (this.getCurrentPage() > 1) {
      const url = this.getBaseCommentsUrl();

      url.searchParams.set('reviews_order', this.getSorting());
      url.hash = 'reviews';
      window.history.replaceState({}, '', url.href);

      this.fetchComments(this.getSorting());
    }
  }

  onClickHandle = (event) => {
    const closestButton = event.target.closest('button');

    if (closestButton && closestButton.id === this.loadMoreCommentsButton.id) {
      this.loadMoreComments();
    }
  }

  onChangeHandle = (event) => {
    const closestSelect = event.target.closest('select');

    if (closestSelect && closestSelect.id === this.sortingElement.id) {
      this.fetchComments(event.target.value);
    }
  }

  setLoading(loading = true) {
    this.loadMoreCommentsButton.disabled = loading;
    this.loaderElement.ariaHidden = !loading;
  }

  loadMoreComments() {
    let currentPage = this.getCurrentPage();
    currentPage++;

    const url = this.getBaseCommentsUrl();
    const pathname = url.pathname.endsWith('/') ? url.pathname.slice(0, -1) : url.pathname;

    url.pathname = `${pathname}/comment-page-${currentPage}/`;
    url.searchParams.set('reviews_order', this.getSorting());

    this.fetch(url.href, (dom) => {
      const commentsElement = dom.getElementById('comments');
      const reviewElements = commentsElement.querySelectorAll('li.review');

      reviewElements.forEach((element) => {
        if (this.commentListElement.querySelector('#' + element.id)) {
          return;
        }

        this.commentListElement.append(element);
      });

      this.updateOptions((options) => ({ ...options, currentPage }) );
      this.loadMoreCommentsButton.hidden = this.getCurrentPage() === this.getTotalPages();
    });
  }

  fetchComments(sortingValue) {
    const url = this.getBaseCommentsUrl();
    url.searchParams.set('reviews_order', sortingValue);

    this.fetch(url.href, (dom) => {
      const root = dom.getElementById('comments');
      const list = dom.getElementById('comment-list');

      this.commentListElement.innerHTML = list.innerHTML;
      this.updateOptions(() => JSON.parse(root.dataset.options));

      this.loadMoreCommentsButton.hidden = !(this.getTotalCount() > this.getCurrentCommentsCount());
    });
  }

  fetch(url, onSuccess) {
    this.setLoading(true);

    fetchHtml(url)
      .then((dom) => {
        onSuccess(dom);
      })
      .catch((error) => {
        alert( 'Error' )
        console.error(error);
      })
      .finally(() => this.setLoading(false));
  
  }
}
