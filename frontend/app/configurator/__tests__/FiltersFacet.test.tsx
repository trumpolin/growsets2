import { render } from "@testing-library/react";
import FiltersFacet from "@/app/configurator/FiltersFacet";
import { useInfiniteQuery } from "@tanstack/react-query";
import { fetchFilterOptions } from "@/lib/api";
import { useSelection } from "@/components/SelectionProvider";

jest.mock("@tanstack/react-query", () => ({
  useInfiniteQuery: jest.fn(),
}));

jest.mock("@/components/SelectionProvider", () => ({
  useSelection: jest.fn(),
}));

jest.mock("@/lib/api", () => ({
  fetchFilterOptions: jest.fn(),
}));

describe("FiltersFacet", () => {
  it("fetches filter options for selected category", () => {
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

    render(<FiltersFacet />);

    const options = (useInfiniteQuery as jest.Mock).mock.calls[0][0];
    expect(options.queryKey).toEqual(["filterOptions", "books"]);
    options.queryFn({ pageParam: 1 });
    expect(fetchFilterOptions).toHaveBeenCalledWith("books", 1, 10, undefined);
  });
});
