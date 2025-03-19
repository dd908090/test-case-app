import { useState } from 'react';
import { router } from '@inertiajs/react';
import '/var/www/link-app-v2/resources/css/EditPageStyle.css';

export default function EditPage({ link }) {
  const [originalUrl, setOriginalUrl] = useState(link.original_url);
  const [customUrl, setCustomUrl] = useState(link.custom_url || '');
  const [expiredAt, setExpiredAt] = useState(link.expired_at ? link.expired_at.slice(0, 10) : ''); // Форматируем дату для input[type="date"]
  const [error, setError] = useState(null);

  const handleSubmit = (e) => {
    e.preventDefault();
    setError(null);

    const data = {
      original_url: originalUrl || '',
      custom_url: customUrl || null,
      expired_at: expiredAt || null,
    };

    router.put(route('links.update', { link: link.id }), data, {
      onError: (errors) => setError(errors),
    });
  };

  const handleBack = () => {
    // Возврат на предыдущую страницу
    router.get(route('links.show', { link: link.id }));
  };

  return (
    <div className="container">
      <div className="header">
        <h1>Редактировать ссылку</h1>
      </div>

      {error && (
        <div className="error-message">
          Пожалуйста, проверьте введенные данные.
        </div>
      )}

      <form onSubmit={handleSubmit} className="form-container">
        <div className="form-group">
          <label className="form-label">Оригинальная ссылка</label>
          <input
            type="url"
            required
            value={originalUrl}
            onChange={(e) => setOriginalUrl(e.target.value)}
            className="form-input"
            placeholder="https://example.com"
          />
        </div>

        <div className="form-group">
          <label className="form-label">Пользовательский URL (опционально)</label>
          <input
            type="text"
            value={customUrl}
            onChange={(e) => setCustomUrl(e.target.value)}
            className="form-input"
            placeholder="Введите свой URL или оставьте пустым"
          />
        </div>

        <div className="form-group">
          <label className="form-label">Дата истечения (опционально)</label>
          <input
            type="date"
            value={expiredAt}
            onChange={(e) => setExpiredAt(e.target.value)}
            className="form-input"
          />
        </div>

        <div className="button-container">
          <button
            type="submit"
            className="submit-button"
          >
            Сохранить изменения
          </button>
          <button
            type="button"
            className="back-button"
            onClick={handleBack}
          >
            Назад
          </button>
        </div>
      </form>
    </div>
  );
}
