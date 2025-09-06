import { render } from "@testing-library/react";
import CategoryFacet from "@/app/configurator/CategoryFacet";
import { useInfiniteQuery } from "@tanstack/react-query";
import { fetchCategoryArticles } from "@/lib/api";
import { useSelection } from "@/components/SelectionProvider";

jest.mock("@tanstack/react-query", () => ({
  useInfiniteQuery: jest.fn(),
  useQueryClient: () => ({ invalidateQueries: jest.fn() }),
}));

jest.mock("@/components/SelectionProvider", () => ({
  useSelection: jest.fn(),
}));

jest.mock("@/lib/api", () => ({
  fetchCategoryArticles: jest.fn(),
}));

describe("CategoryFacet", () => {
  it("passes selected category to query and fetch", () => {
    (useSelection as jest.Mock).mockReturnValue({
      selections: { category: "books" },
      setSelection: jest.fn(),
    });
    (useInfiniteQuery as jest.Mock).mockReturnValue({
      data: { pages: [{ items: [] }] },
      fetchNextPage: jest.fn(),
      hasNextPage: false,
      isFetchingNextPage: false,
    });

    render(<CategoryFacet />);

    const options = (useInfiniteQuery as jest.Mock).mock.calls[0][0];
    expect(options.queryKey).toEqual(["categoryArticles", "books"]);
    options.queryFn({ pageParam: 1 });
    expect(fetchCategoryArticles).toHaveBeenCalledWith(
      "books",
      1,
      10,
      undefined,
    );
  });
});
