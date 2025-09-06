"use client";

interface Article {
  id: string;
  title: string;
  description?: string;
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
    <li className="rounded border p-2 hover:bg-gray-50">
      <div className="flex items-center justify-between">
        <div
          className="flex-1 cursor-pointer"
          onClick={() => onToggle?.(article.id)}
        >
          <h3 className="font-medium">{article.title}</h3>
          {article.description && (
            <p className="text-sm text-gray-600">{article.description}</p>
          )}
        </div>
        <button
          className="ml-2 rounded bg-green-500 px-2 py-1 text-sm text-white"
          onClick={() => onToggle?.(article.id)}
        >
          {selected ? "Im Set" : "Ins Set"}
        </button>
      </div>
    </li>
  );
}
