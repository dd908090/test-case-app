import '/var/www/link-app-v2/resources/css/ShowPageStyle.css';

import { Link, router } from '@inertiajs/react';

export default function ShowPage({ link }) {
  const handleBack = () => {
    // Возврат на предыдущую страницу
    router.get(route('links.index'));
  };

  return (
    <div className="container">
      <div className="header">
        <h1>Информация о ссылке</h1>
      </div>

      <div className="details-container">
        <div className="detail-item">
          <span className="detail-label">ID:</span>
          <span className="detail-value">{link.id}</span>
        </div>

        <div className="detail-item">
          <span className="detail-label">Оригинальная ссылка:</span>
          <a
            href={link.original_url}
            target="_blank"
            rel="noopener noreferrer"
            className="detail-value link"
          >
            {link.original_url}
          </a>
        </div>

        <div className="detail-item">
          <span className="detail-label">Короткая ссылка:</span>
          <a
            href={route('links.redirect', { short_link: link.short_url })}
            target="_blank"
            rel="noopener noreferrer"
            className="detail-value link"
          >
            http://{link.short_url}
          </a>
        </div>

        <div className="detail-item">
          <span className="detail-label">Дата истечения:</span>
          <span className="detail-value">
            {new Date(link.expired_at).toLocaleString()}
          </span>
        </div>

        <div className="detail-item">
          <span className="detail-label">Дата создания:</span>
          <span className="detail-value">
            {new Date(link.created_at).toLocaleString()}
          </span>
        </div>

        <div className="detail-item">
          <span className="detail-label">Дата обновления:</span>
          <span className="detail-value">
            {new Date(link.updated_at).toLocaleString()}
          </span>
        </div>
      </div>

      <div className="button-container">
        <button
          className="back-button"
          onClick={handleBack}
        >
          Назад
        </button>
      </div>
    </div>
  );
}
