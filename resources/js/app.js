import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';

$(document).ready(function() {
    // 検索フォームの送信
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        const url = $(this).attr('action');
        const data = $(this).serialize();

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function(response) {
                $('#product-list').html(response);
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
                $('#product-list').html(response);
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
        const confirmDelete = confirm('本当に削除しますか?');

        if (confirmDelete) {
            $.ajax({
                url: `/products/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $(`.delete-btn[data-id="${id}"]`).closest('tr').remove();
                        alert(response.message);
                    } else {
                        alert('削除に失敗しました。');
                    }
                },
                error: function(xhr) {
                    alert('エラーが発生しました。');
                    console.log(xhr.responseText);
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