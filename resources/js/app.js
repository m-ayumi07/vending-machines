import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';

$(document).ready(function() {
    console.log('jQuery is loaded and ready');

    // 検索フォームの送信
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        console.log('Search form submitted');
        const url = $(this).attr('action');
        const data = $(this).serialize();

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function(response) {
                console.log('Search successful');
                var result = $(response).find('#product-list');
                $('#product-list').html(result);
                history.pushState(null, '', url + '?' + data);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    });

    // ソート機能
    $(document).on('click', '.sort-link', function(e) {
        e.preventDefault();
        console.log('Sort link clicked');
        const column = $(this).data('column');
        const currentSort = getUrlParameter('sort');
        const currentOrder = getUrlParameter('order');
        let order = 'asc';

        if (currentSort === column && currentOrder === 'asc') {
            order = 'desc';
        }

        const url = updateQueryStringParameter(window.location.href, 'sort', column);
        const newUrl = updateQueryStringParameter(url, 'order', order);

        $.ajax({
            url: newUrl,
            type: 'GET',
            success: function(response) {
                console.log('Sort successful');
                var result = $(response).find('#product-list');
                $('#product-list').html(result);
                history.pushState(null, '', newUrl);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    });

    // 削除機能
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        console.log('Delete button clicked for id:', id);
        const confirmDelete = confirm('本当に削除しますか?');

        if (confirmDelete) {
            $.ajax({
                url: `/products/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Delete successful');
                    if (response.success) {
                        $(`.delete-btn[data-id="${id}"]`).closest('tr').remove();
                        alert(response.message);
                    } else {
                        alert('削除に失敗しました。');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    alert('エラーが発生しました。');
                }
            });
        }
    });

    // URLパラメータを取得する関数
    function getUrlParameter(name) {
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    // URLパラメータを更新する関数
    function updateQueryStringParameter(uri, key, value) {
        const url = new URL(uri);
        url.searchParams.set(key, value);
        return url.toString();
    }
});