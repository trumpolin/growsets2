"use client";

interface Article {
  id: string;
  title: string;
  description?: string;
  image?: string;
  price?: number;
}

export default function ArticleListItem({
  article,
  selected = false,
  onToggle,
}: {
  article: Article;
  selected?: boolean;
  onToggle?: (id: string) => void;
}) {
  return (
    <li className="rounded-lg border p-3 hover:bg-gray-50">
      <div className="flex items-center gap-4">
        {article.image && (
          <img
            src={article.image}
            alt={article.title}
            className="h-16 w-16 rounded object-cover"
          />
        )}
        <div
          className="flex-1 cursor-pointer"
          onClick={() => onToggle?.(article.id)}
        >
          <h3 className="font-medium">{article.title}</h3>
          {article.description && (
            <p className="text-sm text-gray-600">{article.description}</p>
          )}
        </div>
        {article.price !== undefined && (
          <span className="font-semibold">{article.price} €</span>
        )}
        {onToggle && (
          <button
            className="ml-2 rounded bg-green-500 px-3 py-1 text-sm text-white"
            onClick={() => onToggle(article.id)}
          >
            {selected ? "Im Set" : "In's Set"}
          </button>
        )}
      </div>
    </li>
  );
}
