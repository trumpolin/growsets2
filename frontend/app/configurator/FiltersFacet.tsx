"use client";
import { fetchFilterOptions } from "@/lib/api";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";
import { useInfiniteQuery } from "@tanstack/react-query";

export default function FiltersFacet() {
  const { selections, setSelection } = useSelection();
  const category = selections.category ?? "default";

  const {
    data,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
  } = useInfiniteQuery({
    queryKey: ["filterOptions", category],
    queryFn: ({ pageParam = 1, signal }) =>
      fetchFilterOptions("default", pageParam, 10, signal),
    getNextPageParam: (lastPage) =>
      lastPage.page < lastPage.totalPages ? lastPage.page + 1 : undefined,
    initialPageParam: 1,
  });

  const options = data?.pages.flatMap((p) => p.items) ?? [];

  return (
    <FacetPanel title="Filters">
      <ul className="space-y-1">
        {options.map((opt) => (
          <li
            key={opt.value}
            className="cursor-pointer rounded p-2 hover:bg-gray-50"
            onClick={() => setSelection("filter", opt.value)}
          >
            {opt.label}
          </li>
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

