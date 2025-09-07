"use client";
import { fetchCategoryArticles } from "@/lib/api";
import ArticleListItem from "@/components/ArticleListItem";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";
import { useInfiniteQuery } from "@tanstack/react-query";

interface ArticleFacetProps {
  category: string;
  selectionKey: string;
  title: string;
  queryKey?: unknown[];
  fetchArgs?: (string | undefined)[];
  onSelect?: (id: string | null) => void;
}

export default function ArticleFacet({
  category,
  selectionKey,
  title,
  queryKey,
  fetchArgs = [],
  onSelect,
}: ArticleFacetProps) {
  const { selections, setSelection } = useSelection();
  const selected = selections[selectionKey];

  const { data, fetchNextPage, hasNextPage, isFetchingNextPage } =
    useInfiniteQuery({
      queryKey: queryKey ?? [`${selectionKey}Articles`, category],
      queryFn: ({ pageParam = 1, signal }) =>
        fetchCategoryArticles(category, pageParam, 10, signal, ...fetchArgs),
      getNextPageParam: (lastPage) =>
        lastPage.page < lastPage.totalPages ? lastPage.page + 1 : undefined,
      initialPageParam: 1,
    });

  const articles = data?.pages.flatMap((p) => p.items) ?? [];

  const handleToggle = (id: string) => {
    const next = id === selected ? null : id;
    setSelection(selectionKey, next);
    onSelect?.(next);
  };

  return (
    <FacetPanel title={title}>
      <ul className="space-y-2">
        {articles.map((article) => (
          <ArticleListItem
            key={article.id}
            article={article}
            selected={article.id === selected}
            onToggle={handleToggle}
          />
        ))}
      </ul>
      {hasNextPage && (
        <button
          className="mt-2 rounded bg-gray-200 px-3 py-1"
          onClick={() => fetchNextPage()}
          disabled={isFetchingNextPage}
        >
          {isFetchingNextPage ? "Loading..." : "Load more"}
        </button>
      )}
    </FacetPanel>
  );
}
