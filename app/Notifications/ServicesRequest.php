<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServicesRequest extends Notification
{
    use Queueable;

    protected $data;
    protected $formType;
    protected $type;  // Menyimpan tipe notifikasi: tanggapan, komentar, atau pengajuan baru

    /**
     * Create a new notification instance.
     *
     * @param $data
     * @param $formType
     * @param $type
     */
    public function __construct($data, $formType, $type = null)
    {
        $this->data = $data;
        $this->formType = $formType;
        $this->type = $type;  // Jenis notifikasi: 'tanggapan', 'komentar', atau 'pengajuan'
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // 'mail' jika ingin mengirim ke email
        // jika ingin ke kirim ke email tambhakan ini ,'mail'
    }

    /**
     * Get the mail representation of the notification.
     */
  public function toMail($notifiable)
    {
        // Set URL berdasarkan tipe notifikasi
        if ($this->type === 'tanggapan') {
        $url = route('user.pengaduan.index');
            return (new MailMessage)
                ->subject('Tanggapan Resmi atas Laporan Pengaduan Anda')
                ->greeting('Yth. Pelapor,')
                ->line('Kami informasikan bahwa admin telah memberikan tanggapan resmi terhadap laporan pengaduan yang Anda sampaikan.')
                ->action('Lihat Tanggapan Selengkapnya', $url)
                ->line('Terima kasih atas partisipasi Anda dalam meningkatkan layanan pendidikan di Kota Depok.');
        }

        if ($this->type === 'komentar') {
            $url = route('user.pengaduan.index');
            return (new MailMessage)
                ->subject('Komentar Tambahan pada Tanggapan Pengaduan Anda')
                ->greeting('Yth. Pelapor,')
                ->line('Admin telah menambahkan komentar pada tanggapan laporan pengaduan Anda.')
                ->line('Isi komentar:')
                ->line('"' . $this->data->komentar . '"')
                ->action('Lihat Komentar', $url)
                ->line('Terima kasih atas perhatian dan kerja samanya.');
        }

        // Default untuk pengaduan baru (notifikasi ke admin)
        $url = route('admin.lapor.index');
            return (new MailMessage)
                ->subject('Pengaduan Baru Telah Diterima')
                ->greeting('Yth. Admin,')
                ->line('Sistem telah menerima pengaduan baru dari masyarakat.')
                ->action('Tinjau Pengaduan', $url)
                ->line('Harap segera ditindaklanjuti sesuai prosedur yang berlaku.');
                }


    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        if ($this->type === 'tanggapan') {
            return [
                'message' => 'Admin memberikan tanggapan pada laporan pengaduan Anda.',
                'lapor_id' => $this->data->lapor_id,
                'tanggapan' => $this->data->tanggapan,
                'url' => url('/pengaduan/'.$this->data->lapor_id),
                'time' => now()->format('d M Y H:i'),
            ];
        }

        if ($this->type === 'komentar') {
            return [
                'message' => 'Admin memberikan komentar pada tanggapan laporan Anda.',
                'lapor_id' => $this->data->lapor_id,
                'komentar' => $this->data->komentar,
                'url' => url('/pengaduan/'.$this->data->lapor_id),
                'time' => now()->format('d M Y H:i'),
            ];
        }

        // Default untuk pengajuan baru
       return [
        'title' => 'Pengajuan Baru ' . ucfirst($this->formType),
        'message' => 'Ada pengajuan baru dari ' . $this->data['nama'],
        'formType' => $this->formType,
        'url' => url('/admin/' . $this->formType),
        'time' => now()->format('d M Y H:i'),
    ];
    }

    /**
     * Menentukan URL berdasarkan jenis formulir
     */
    // private function getFormUrl()
    // {
    //     // Menentukan URL yang sesuai berdasarkan formType
    //     return url('/admin/' . $this->formType);
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->type === 'tanggapan') {
            return [
                'message' => 'Admin memberikan tanggapan pada laporan pengaduan Anda.',
                'lapor_id' => $this->data->lapor_id,
                'tanggapan' => $this->data->tanggapan,
            ];
        }

        if ($this->type === 'komentar') {
            return [
                'message' => 'Admin memberikan komentar pada tanggapan laporan Anda.',
                'lapor_id' => $this->data->lapor_id,
                'komentar' => $this->data->komentar,
            ];
        }

        // Default untuk pengajuan baru
        return [
            'message' => 'Ada pengajuan baru dari ' . $this->data['nama'],
            'formType' => $this->formType,
        ];
    }
}
