# WordPress - Cron Jobs

Tài liệu tham khảo: https://developer.wordpress.org/plugins/cron/

## Những điểm lưu ý chính

- Cron Job dựa theo action page load của người dùng/bot.

> Đó là lý do tại sao nhiều người khuyên set disable cron mặc định của WordPress, và [set access bằng cron cố định](https://github.com/codetot-web/dev-guideline/blob/main/wp-cron-jobs.md#set-cron-job-hosting-thay-v%C3%AC-s%E1%BB%AD-d%E1%BB%A5ng-m%E1%BA%B7c-%C4%91%E1%BB%8Bnh) do công cụ hosting cung cấp.

- Cron Job được set không có nghĩa là 100% sẽ chạy ở thời điểm dự kiến, mà thực tế được xếp hàng (queue) và chạy ở thời điểm page load tiếp theo.

> Hiểu nôm na, giả sử ta lên lịch hàng ngày backup vào 7:00, nhưng thời điểm đó KHÔNG có người/bot truy cập, thì khi lần tiếp theo có truy cập (ví dụ 07:05), hệ thống sẽ thực thi cả những action cron nào chưa chạy.

## Tạo Cron Job đầu tiên

Dưới đây là 1 cron job đầu tiên, bao gồm các function custom sau:

```
- ct_cron_jobs_init - dùng wp_next_scheduled() kiểm tra cron có chưa, nếu chưa thì dùng wp_schedule_event() để set
- ct_cron_job_example - tên của action sẽ chạy khi cron job chạy - nó chỉ là tên của action, không cần function thực sự
- ct_cron_job_run_action - là function sẽ chạy vào hook ct_cron_job_example để thực thi nhiệm vụ
```

Ta có thể cần edit để tạo ra 1 thời gian lặp lại (ví dụ: mỗi 2 phút - **2minutes**) để đăng ký với WordPress.
Mặc định WordPress cung cấp sẵn: `hourly`, `twicedaily`, `daily`, `weekly`

**Code mẫu toàn bộ**

```php
add_action('init', 'ct_cron_jobs_init');

function ct_cron_jobs_init()
{
	if (!wp_next_scheduled('ct_cron_job_example')) {
		// Schedule the event
		wp_schedule_event(time(), '2minutes', 'ct_cron_job_example');
	}
}

add_filter('cron_schedules', 'ct_cron_schedules');
function ct_cron_schedules($schedules)
{
	// Default: hourly, twicedaily, daily, weekly
	// Add new settings
	$schedules['2minutes'] = array(
		'interval' => 2 * MINUTE_IN_SECONDS,
		'display' => __('Every 2 minutes', 'ct-test-theme')
	);

	return $schedules;
}

add_action('ct_cron_job_example', 'ct_cron_job_run_action');
function ct_cron_job_run_action()
{
	error_log(__FUNCTION__ . ':: Run with timestamp ' . time());
}
```

## Set cron job hosting thay vì sử dụng mặc định

Xem tài liệu: https://developer.wordpress.org/plugins/cron/hooking-wp-cron-into-the-system-task-scheduler/

Một ví dụ triển khai cron job trên hosting/VPS: https://easyengine.io/tutorials/wordpress/wp-cron-crontab/

**Mục tiêu:** Đảm bảo vào đúng thời điểm dự kiến luôn luôn chạy được Cron Job thay vì dồn Cron Job lại vào lần truy cập kế tiếp.
